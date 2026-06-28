<?php

namespace App\Features\DocumentProcesses\Services;

use App\Features\DocumentCategories\Models\DocumentCategory;
use App\Features\DocumentProcesses\Models\DocumentProcess;

class DocumentProcessResolver
{
    public function resolve(DocumentCategory $documentCategory): ?DocumentProcess
    {
        return $documentCategory->documentProcess;
    }
}