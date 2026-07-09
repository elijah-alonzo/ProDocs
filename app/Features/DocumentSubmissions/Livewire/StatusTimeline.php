<?php

namespace App\Features\DocumentSubmissions\Livewire;

use App\Features\DocumentSubmissions\Models\DocumentSubmission;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class StatusTimeline extends Component
{
    public DocumentSubmission $submission;

    public function render(): View
    {
        return view('StatusTimeline');
    }
}