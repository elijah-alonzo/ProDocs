<?php

namespace App\Features\DocumentSubmissions\Services;

use App\Features\DocumentSubmissions\Models\DocumentSubmission;
use Illuminate\Support\Collection;

class SubmissionTimelineBuilder
{
    /**
     * Builds an ordered timeline of entries for a submission by merging
     * the full stage pipeline with actual approval history. Each entry
     * represents one (stage, cycle) pair with its state and any recorded
     * approval data.
     *
     * Entry shape:
     * [
     *   'stage'    => DocumentProcessStage,
     *   'cycle'    => int,
     *   'state'    => 'approved' | 'rejected' | 'current' | 'pending',
     *   'approval' => DocumentApproval|null,
     * ]
     *
     * Multiple cycles for the same stage (restart after rejection) produce
     * multiple entries in chronological order, preserving full history.
     */
    public function build(DocumentSubmission $submission): Collection
    {
        $stages = $submission->documentProcess->stages; // ordered by stage_order via relation

        // Sort approvals by acted_at ascending so earlier cycles come first,
        // then group by cycle so we can replay each attempt in order.
        $approvalsByCycle = $submission->approvals
            ->sortBy('acted_at')
            ->groupBy('cycle');

        $entries = collect();
        $currentCycle = $submission->current_cycle;

        // Replay completed cycles first (any cycle before the current one).
        foreach ($approvalsByCycle as $cycle => $cycleApprovals) {
            if ((int) $cycle === $currentCycle) {
                continue; // handled separately below
            }

            $approvalsByStage = $cycleApprovals->keyBy('document_process_stage_id');

            foreach ($stages as $stage) {
                $approval = $approvalsByStage->get($stage->id);

                if ($approval) {
                    $entries->push([
                        'stage'    => $stage,
                        'cycle'    => (int) $cycle,
                        'state'    => $approval->status, // 'approved' | 'rejected'
                        'approval' => $approval,
                    ]);
                }
            }
        }

        // Now render the current cycle: past approvals + current + future stages.
        $currentCycleApprovals = $approvalsByCycle->get($currentCycle, collect());
        $approvalsByStage = $currentCycleApprovals->keyBy('document_process_stage_id');

        foreach ($stages as $stage) {
            $approval = $approvalsByStage->get($stage->id);

            $state = match (true) {
                $approval !== null                                          => $approval->status,
                $stage->id === $submission->current_process_stage_id       => 'current',
                default                                                     => 'pending',
            };

            $entries->push([
                'stage'    => $stage,
                'cycle'    => $currentCycle,
                'state'    => $state,
                'approval' => $approval,
            ]);
        }

        return $entries;
    }
}