<?php

namespace App\Filament\Admin\Resources\DocumentCategories\RelationManagers;

use App\Filament\Admin\Resources\DocumentCategories\RelationManagers\Schemas\DocumentCategoryFieldsForm;
use App\Filament\Admin\Resources\DocumentCategories\RelationManagers\Tables\DocumentCategoryFieldsTable;
use Filament\Resources\RelationManagers\RelationManager as BaseRelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class DocumentCategoryFields extends BaseRelationManager
{
    protected static string $relationship = 'fields';

    protected static bool $canCreateAnother = false;

    protected static ?string $title = 'Document Category Fields';

    public function form(Schema $schema): Schema
    {
        return DocumentCategoryFieldsForm::configure($schema);
    }

    public function table(Table $table): Table
    {
        return DocumentCategoryFieldsTable::configure($table);
    }
}