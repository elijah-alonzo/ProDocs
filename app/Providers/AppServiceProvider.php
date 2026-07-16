<?php

namespace App\Providers;

use App\Features\Users\Models\User;
use App\Features\Logs\Observers\ModelActionObserver;
use App\Features\DocumentSubmissions\Livewire\SubmissionsFeed;
use App\Features\DocumentSubmissions\Livewire\DocumentDetailsPanel;
use App\Features\DocumentSubmissions\Livewire\StatusTimeline;
use App\Features\DocumentSubmissions\Livewire\DocumentPreview;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Schema::defaultStringLength(191);

        User::observe(ModelActionObserver::class);

        // View locations
        View::addLocation(app_path('Filament/App/Custom'));
        View::addLocation(app_path('Features/DocumentApprovals/Views'));
        View::addLocation(app_path('Features/DocumentSubmissions/Views'));

        // Livewire components living inside Features/
        Livewire::component('submissions-feed', SubmissionsFeed::class);
        Livewire::component('document-details-panel', DocumentDetailsPanel::class);
        Livewire::component('status-timeline', StatusTimeline::class);
        Livewire::component('document-preview', DocumentPreview::class);
    }
}