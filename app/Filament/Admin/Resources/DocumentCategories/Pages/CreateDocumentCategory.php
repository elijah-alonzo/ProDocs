<?php

namespace App\Filament\Admin\Resources\DocumentCategories\Pages;

use App\Filament\Admin\Resources\DocumentCategories\DocumentCategoryResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;

class CreateDocumentCategory extends CreateRecord
{
    protected static string $resource = DocumentCategoryResource::class;

    protected static bool $canCreateAnother = false;

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }

    protected function getFormActions(): array
    {
        return [];
    }
    protected function getHeaderActions(): array
    {
        return [
            $this->getCreateFormAction(),

            Action::make('cancel')
                ->label('Cancel')
                ->url(static::getResource()::getUrl('index'))
                ->color('gray'),
        ];
    }
}