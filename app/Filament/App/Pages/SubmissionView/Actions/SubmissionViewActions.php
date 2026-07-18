<?php

namespace App\Filament\App\Pages\SubmissionView\Actions;

use App\Features\DocumentProcesses\Services\DocumentProcessEngine;
use App\Features\DocumentSubmissions\Models\DocumentSubmission;
use Filament\Actions\Action;

class SubmissionViewActions
{
    public static function configure(DocumentSubmission $submission): array
    {
        $user = auth()->user();
        $stage = $submission->currentProcessStage;
        $canAct = $stage?->isAssignableTo($user) ?? false;

        return [
            Action::make('approve')
                ->label($stage?->action_label ?? 'Approve')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->visible($canAct)
                ->form([
                    \Filament\Forms\Components\Textarea::make('remarks')
                        ->label('Remarks')
                        ->placeholder('Optional remarks for this approval...')
                        ->rows(3),
                ])
                ->action(function (array $data) use ($submission, $user): void {
                    app(DocumentProcessEngine::class)->approve(
                        $submission,
                        $user,
                        $data['remarks'] ?? null
                    );
                })
                ->successNotificationTitle('Approved successfully')
                ->requiresConfirmation()
                ->modalHeading($stage?->action_label ?? 'Approve Submission')
                ->modalDescription('This action will move the submission to the next stage.')
                ->modalSubmitActionLabel($stage?->action_label ?? 'Approve')
                ->after(fn ($livewire) => $livewire->redirect(
                    \App\Filament\App\Pages\SubmissionView::getUrl(['record' => $submission->id])
                )),

            Action::make('reject')
                ->label('Reject')
                ->icon('heroicon-o-x-circle')
                ->color('danger')
                ->visible($canAct)
                ->form([
                    \Filament\Forms\Components\Textarea::make('remarks')
                        ->label('Reason for Rejection')
                        ->placeholder('Explain why this submission is being rejected...')
                        ->rows(3)
                        ->required(),
                ])
                ->action(function (array $data) use ($submission, $user): void {
                    app(DocumentProcessEngine::class)->reject(
                        $submission,
                        $user,
                        $data['remarks']
                    );
                })
                ->successNotificationTitle('Submission rejected')
                ->requiresConfirmation()
                ->modalHeading('Reject Submission')
                ->modalDescription('This will reject the submission and notify the uploader.')
                ->modalSubmitActionLabel('Reject')
                ->modalSubmitAction(fn ($action) => $action->color('danger'))
                ->after(fn ($livewire) => $livewire->redirect(
                    \App\Filament\App\Pages\SubmissionView::getUrl(['record' => $submission->id])
                )),
        ];
    }
}