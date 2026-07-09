<?php

namespace App\Filament\App\Pages;

use App\Features\DocumentSubmissions\Livewire\DocumentDetailsPanel;
use App\Features\DocumentSubmissions\Livewire\DocumentPreview;
use App\Features\DocumentSubmissions\Livewire\StatusTimeline;
use App\Features\DocumentSubmissions\Models\DocumentSubmission;
use Filament\Pages\Page;
use Filament\Schemas\Components\Livewire;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class SubmissionView extends Page
{
    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $title = '';

    public DocumentSubmission $submission;

    public function mount(int $record): void
    {
        $this->submission = DocumentSubmission::with([
            'documentCategory.fields',
            'documentProcess.stages.role',
            'currentProcessStage.role',
            'createdBy',
            'uploaders',
            'approvals.documentProcessStage',
            'approvals.user',
        ])->findOrFail($record);

        // Gate: only involved parties can view this page
        abort_unless(
            $this->submission->isUploaderOrCreator(auth()->user())
                || $this->submission->currentProcessStage?->isAssignableTo(auth()->user()),
            403
        );
    }

    public function getTitle(): string
    {
        return $this->submission->card_title;
    }

    public function content(Schema $schema): Schema
    {
        return $schema
            ->components([
                Livewire::make(DocumentDetailsPanel::class, ['submission' => $this->submission])
                    ->columnSpan(1),

                Livewire::make(DocumentPreview::class, ['submission' => $this->submission])
                    ->columnSpan(1),
            ]);
    }

    public function getColumns(): int|array
    {
        return [
            'md' => 2,
        ];
    }

    public static function getRoutes(): \Closure
    {
        return function () {
            return static::getUrl(['record' => '{record}']);
        };
    }

    public static function getSlug(): string
    {
        return 'submissions/{record}';
    }
}