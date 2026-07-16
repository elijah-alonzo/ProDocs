<?php

namespace App\Features\DocumentSubmissions\Livewire;

use App\Features\DocumentSubmissions\Models\DocumentSubmission;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class DocumentPreview extends Component
{
    public DocumentSubmission $submission;

    public function getFileUrlAttribute(): ?string
    {
        if (! $this->submission->file_path) {
            return null;
        }

        return asset('storage/' . $this->submission->file_path);
    }

    public function getFileExtensionAttribute(): ?string
    {
        if (! $this->submission->file_path) {
            return null;
        }

        return strtolower(pathinfo($this->submission->file_path, PATHINFO_EXTENSION));
    }

    public function getPreviewTypeAttribute(): string
    {
        return match ($this->fileExtension) {
            'pdf'        => 'pdf',
            'jpg', 'jpeg', 'png', 'gif', 'webp' => 'image',
            null         => 'none',
            default      => 'download',
        };
    }

    public function render(): View
    {
        return view('DocumentPreview', [
            'fileUrl'     => $this->fileUrlAttribute,
            'previewType' => $this->previewTypeAttribute,
            'extension'   => $this->fileExtensionAttribute,
        ]);
    }
}