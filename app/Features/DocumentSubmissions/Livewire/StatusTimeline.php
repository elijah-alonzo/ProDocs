<?php

namespace App\Features\DocumentSubmissions\Livewire;

use App\Features\DocumentSubmissions\Models\DocumentSubmission;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Livewire\Component;

class StatusTimeline extends Component
{
    public DocumentSubmission $submission;

    public Collection $timelineEntries;

    /** Currently expanded entry key (stage_id:cycle) for click-to-reveal remarks */
    public ?string $expandedEntry = null;

    public function mount(Collection $timelineEntries): void
    {
        $this->timelineEntries = $timelineEntries;
    }

    public function toggleEntry(string $key): void
    {
        $this->expandedEntry = $this->expandedEntry === $key ? null : $key;
    }

    public function render(): View
    {
        return view('StatusTimeline', [
            'timelineEntries' => $this->timelineEntries,
            'expandedEntry'   => $this->expandedEntry,
        ]);
    }
}