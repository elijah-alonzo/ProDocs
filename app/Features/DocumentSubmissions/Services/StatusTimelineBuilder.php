<?php

namespace App\Features\DocumentSubmissions\Services;

use App\Features\DocumentSubmissions\Models\DocumentSubmission;
use Illuminate\Support\Collection;

class SubmissionTimelineBuilder
{
    public function build(DocumentSubmission $submission): Collection
    {
        $stages = $submission->documentProcess->stages; 

        $approvalsByCycle = $submission->approvals
            ->sortBy('acted_at')
            ->groupBy('cycle');

        $entries = collect();
        $currentCycle = $submission->current_cycle;

        foreach ($approvalsByCycle as $cycle => $cycleApprovals) {
            if ((int) $cycle === $currentCycle) {
                continue; 
            }

            $approvalsByStage = $cycleApprovals->keyBy('document_process_stage_id');

            foreach ($stages as $stage) {
                $approval = $approvalsByStage->get($stage->id);

                if ($approval) {
                    $entries->push([
                        'stage'    => $stage,
                        'cycle'    => (int) $cycle,
                        'state'    => $approval->status, 
                        'approval' => $approval,
                    ]);
                }
            }
        }

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