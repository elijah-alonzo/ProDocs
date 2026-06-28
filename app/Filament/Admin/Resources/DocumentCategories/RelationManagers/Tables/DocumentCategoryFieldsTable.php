<?php

namespace App\Filament\Admin\Resources\DocumentCategories\RelationManagers\Tables;

use App\Features\DocumentCategories\Models\DocumentCategoryField;
use Filament\Actions\ActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class DocumentCategoryFieldsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->description('Configure the fields that users inputs when creating documents.')
            ->recordTitleAttribute('label')
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->columns([
                TextColumn::make('sort_order')->label('#')->sortable(),
                TextColumn::make('label')->searchable(),
                TextColumn::make('field_key')->badge()->color('gray'),
                TextColumn::make('type')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => DocumentCategoryField::TYPES[$state] ?? $state),
                IconColumn::make('is_required')->label('Required')->boolean(),
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Add Field')
                    ->createAnother(false),
            ])
            ->actions([
                ActionGroup::make([
                    EditAction::make(),
                    DeleteAction::make(),
                ]),
            ])
            ->toolbarActions([
                DeleteBulkAction::make(),
            ]);
    }
}