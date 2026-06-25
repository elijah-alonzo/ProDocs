<?php

namespace App\Filament\Admin\Resources\DocumentCategories\Pages;

use App\Filament\Admin\Resources\DocumentCategories\DocumentCategoryResource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditDocumentCategory extends EditRecord
{
    protected static string $resource = DocumentCategoryResource::class;

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
            $this->getSaveFormAction(),

            Action::make('cancel')
                ->label('Cancel')
                ->url(static::getResource()::getUrl('index'))
                ->color('gray'),

            DeleteAction::make(),
        ];
    }
}