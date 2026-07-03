<?php

namespace App\Filament\App\Pages;

use App\Filament\App\Pages\Dashboard\Actions\DashboardActions;
use App\Livewire\App\Dashboard\SubmissionsFeed;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Schemas\Components\Livewire;
use Filament\Schemas\Schema;

class Dashboard extends BaseDashboard
{
    protected static ?string $title = ' ';

    protected static bool $shouldRegisterNavigation = false;

    public function getColumns(): int|array
    {
        return 1;
    }

    public function content(Schema $schema): Schema
    {
        return $schema
            ->components([
                Livewire::make(SubmissionsFeed::class)
                    ->columnSpanFull(),
            ]);
    }

    public function getHeaderActions(): array
    {
        return DashboardActions::configure();
    }
}