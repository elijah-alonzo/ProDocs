<?php

namespace App\Services;

use App\Models\DocumentType;
use App\Features\Workflow\Models\Workflow;

class WorkflowResolver
{
    public function resolve(DocumentType $documentType): ?Workflow
    {
        return $documentType->workflow;
    }
}
