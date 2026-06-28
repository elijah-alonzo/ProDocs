<?php

namespace App\Filament\Admin\Resources\DocumentCategories\RelationManagers\Schemas;

use App\Features\DocumentCategories\Models\DocumentCategoryField;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class DocumentCategoryFieldsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                TextInput::make('label')
                    ->label('Field Label')
                    ->placeholder('e.g. Research Title')
                    ->required()
                    ->maxLength(255)
                    ->prefixIcon('heroicon-o-tag')
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (string $operation, ?string $state, callable $set): void {
                        if ($operation !== 'create' || blank($state)) {
                            return;
                        }

                        $set('field_key', Str::snake(Str::ascii($state)));
                    })
                    ->columnSpanFull(),

                TextInput::make('field_key')
                    ->label('Field Key')
                    ->placeholder('e.g. research_title')
                    ->helperText('Stable data identifier. Spaces and uppercase is prohibitted.')
                    ->required()
                    ->alphaDash()
                    ->prefixIcon('heroicon-o-key')
                    ->maxLength(255),

                Select::make('type')
                    ->label('Field Type')
                    ->options(DocumentCategoryField::TYPES)
                    ->default('text')
                    ->required()
                    ->prefixIcon('heroicon-o-list-bullet')
                    ->live(),

                TextInput::make('help_text')
                    ->label('Help Text')
                    ->placeholder('Optional guidance shown to users')
                    ->prefixIcon('heroicon-o-information-circle')
                    ->maxLength(255)
                    ->columnSpanFull(),

                KeyValue::make('options')
                    ->label('Dropdown Choices')
                    ->keyLabel('Value (stored)')
                    ->valueLabel('Label (shown)')
                    ->reorderable()
                    ->visible(fn (callable $get): bool => $get('type') === 'select')
                    ->columnSpanFull(),

                TextInput::make('sort_order')
                    ->label('Sort Order')
                    ->numeric()
                    ->prefixIcon('heroicon-o-bars-3-bottom-left')
                    ->default(0),

                Toggle::make('is_required')
                    ->label('Required')
                    ->default(false),
            ]);
    }
}