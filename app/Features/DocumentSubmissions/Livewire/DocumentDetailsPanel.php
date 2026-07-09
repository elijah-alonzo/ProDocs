<?php

namespace App\Features\DocumentSubmissions\Livewire;

use App\Features\DocumentSubmissions\Models\DocumentSubmission;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class DocumentDetailsPanel extends Component
{
    public DocumentSubmission $submission;

    public function render(): View
    {
        return view('DocumentDetailsPanel');
    }
}