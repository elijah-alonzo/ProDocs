<a href="{{ \App\Filament\App\Pages\SubmissionView::getUrl(['record' => $submission->id]) }}"
   wire:navigate
   class="block w-full text-left">
    <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl p-5 shadow-sm hover:shadow-md hover:border-primary-400 dark:hover:border-primary-500 transition-all duration-150 cursor-pointer">

        {{-- Title --}}
        <p class="text-base font-semibold text-gray-900 dark:text-white leading-snug truncate">
            {{ $submission->card_title }}
        </p>

        {{-- Document Type --}}
        <p class="mt-0.5 text-sm text-gray-500 dark:text-gray-400 truncate">
            {{ $submission->card_type }}
        </p>

        {{-- Status Badge --}}
        <div class="mt-2">
            <span @class([
                'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium',
                'bg-success-100 text-success-700 dark:bg-success-500/20 dark:text-success-400' => $submission->card_status_color === 'success',
                'bg-danger-100 text-danger-700 dark:bg-danger-500/20 dark:text-danger-400'     => $submission->card_status_color === 'danger',
                'bg-warning-100 text-warning-700 dark:bg-warning-500/20 dark:text-warning-400' => $submission->card_status_color === 'warning',
                'bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-300'               => $submission->card_status_color === 'gray',
            ])>
                {{ ucfirst($submission->status) }}
            </span>
        </div>

        {{-- Assigned Uploaders — truncated to avoid overflow --}}
        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400 flex items-center gap-1.5 min-w-0">
            <x-heroicon-o-user-group class="w-4 h-4 text-gray-400 dark:text-gray-500 shrink-0" />
            <span class="truncate">{{ $submission->card_uploader_label }}</span>
        </p>

        {{-- Timestamp --}}
        <p class="mt-2 text-xs text-gray-400 dark:text-gray-500 flex items-center gap-1.5">
            <x-heroicon-o-clock class="w-3.5 h-3.5 shrink-0" />
            {{ $submission->created_at->format('M d, Y, g:i A') }}
        </p>

    </div>
</a>