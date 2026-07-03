<?php

namespace App\Filament\App\Pages\Dashboard\Actions;

use App\Features\DocumentCategories\Models\DocumentCategory;
use Filament\Actions\Action;

class DashboardActions
{
    public static function configure(): array
    {
        return [
            Action::make('create_submission')
                ->label('New Submission')
                ->icon('heroicon-o-plus')
                ->visible(function (): bool {
                    $user = auth()->user();
                    $roleNames = $user->roles->pluck('name')->toArray();

                    return DocumentCategory::where('is_active', true)
                        ->get()
                        ->contains(function (DocumentCategory $category) use ($roleNames): bool {
                            $allowed = $category->allowed_creator_roles ?? [];
                            return count(array_intersect($roleNames, $allowed)) > 0;
                        });
                })
                ->url(fn (): string => route('filament.app.resources.document-submissions.create')),
        ];
    }
}