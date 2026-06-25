<?php

namespace App\Filament\Admin\Resources\DocumentSubmissions\Tables;

use App\Features\DocumentSubmissions\Models\DocumentSubmission;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class DocumentSubmissionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->heading('All Submissions')
            ->description('Track all document submissions and their current status.')
            ->columns([
                TextColumn::make('display_name')
                    ->label('Submission')
                    ->getStateUsing(fn (DocumentSubmission $record): string => $record->display_name)
                    ->searchable(query: function ($query, string $search): void {
                        $query->whereHas('documentCategory', fn ($categoryQuery) => $categoryQuery->where('name', 'like', "%{$search}%"))
                            ->orWhereHas('createdBy', fn ($creatorQuery) => $creatorQuery->where('first_name', 'like', "%{$search}%")
                                ->orWhere('last_name', 'like', "%{$search}%"));
                    })
                    ->sortable(query: function ($query, string $direction): void {
                        $query->orderBy('created_at', $direction);
                    }),
                TextColumn::make('documentCategory.name')
                    ->label('Category')
                    ->badge()
                    ->color('primary'),
                TextColumn::make('createdBy.full_name')
                    ->label('Created By')
                    ->sortable(),
                TextColumn::make('uploaders.full_name')
                    ->label('Assigned Uploaders')
                    ->listWithLineBreaks()
                    ->limitList(3)
                    ->placeholder('Unassigned'),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'approved' => 'success',
                        'rejected' => 'danger',
                        'pending' => 'warning',
                        default => 'gray',
                    }),
                TextColumn::make('currentStep.step_name')
                    ->label('Current Stage')
                    ->default('Completed')
                    ->badge()
                    ->color(fn ($state) => $state ? 'info' : 'success'),
                TextColumn::make('created_at')
                    ->label('Date Initiated')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([])
            ->actions([
                ActionGroup::make([
                    EditAction::make(),
                    DeleteAction::make(),
                ]),
            ]);
    }
}