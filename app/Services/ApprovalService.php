<?php

namespace App\Services;

use App\Models\Document;
use App\Models\User;
use App\Features\Workflow\Models\WorkflowStep;
use App\Models\DocumentApproval;

class ApprovalService
{
    public function logAction(Document $document, ?WorkflowStep $step, User $user, string $status, ?string $remarks = null): DocumentApproval
    {
        return DocumentApproval::create([
            'document_id' => $document->id,
            'workflow_step_id' => $step?->id,
            'approved_by' => $user->id,
            'status' => $status,
            'remarks' => $remarks,
            'acted_at' => now(),
        ]);
    }
}
