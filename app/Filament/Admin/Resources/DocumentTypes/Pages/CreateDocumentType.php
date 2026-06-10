<?php

namespace App\Filament\Admin\Resources\Data\Pages;

use App\Filament\Admin\Resources\DocumentTypeResource;
use Filament\Resources\Pages\CreateRecord;

class CreateDocumentType extends CreateRecord
{
    protected static string $resource = DocumentTypeResource::class;
}
