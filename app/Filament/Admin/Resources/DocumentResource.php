<?php

namespace App\Filament\Admin\Resources;

use App\Models\Document;
use App\Models\DocumentType;
use App\Filament\Admin\Resources\DocumentResource\Pages\CreateDocument;
use App\Filament\Admin\Resources\DocumentResource\Pages\EditDocument;
use App\Filament\Admin\Resources\DocumentResource\Pages\ListDocuments;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Components\Placeholder;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use UnitEnum;

class DocumentResource extends Resource
{
    protected static ?string $model = Document::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-document-arrow-up';

    protected static UnitEnum|string|null $navigationGroup = 'Document Management';

    protected static ?string $navigationLabel = 'Document Submissions';

    protected static ?int $navigationSort = 10;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Select::make('document_type_id')
                    ->label('Document Type')
                    ->options(fn () => DocumentType::where('is_active', true)->pluck('name', 'id'))
                    ->required(),
                FileUpload::make('file_path')
                    ->label('Document File')
                    ->required()
                    ->disk('public')
                    ->directory('documents'),
                Placeholder::make('timeline')
                    ->label('')
                    ->visible(fn ($record) => $record !== null)
                    ->content(fn ($record) => $record ? view('admin.documenttimeline.holder', ['document' => $record]) : null)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('documentType.name')
                    ->label('Type')
                    ->badge()
                    ->color('primary'),
                TextColumn::make('submittedBy.full_name')
                    ->label('Submitted By')
                    ->sortable(),
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
                    ->label('Date Submitted')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListDocuments::route('/'),
            'create' => CreateDocument::route('/create'),
            'edit' => EditDocument::route('/{record}/edit'),
        ];
    }
}
