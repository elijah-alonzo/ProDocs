<div class="space-y-3">
    @forelse ($submissions as $submission)
        @include('SubmissionCard', ['submission' => $submission])
    @empty
        <div class="flex flex-col items-center justify-center py-16 text-center">
            <x-heroicon-o-inbox class="w-12 h-12 text-gray-300 dark:text-gray-600 mb-3" />
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">No submissions yet</p>
            <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">
                Submissions assigned to you or awaiting your action will appear here.
            </p>
        </div>
    @endforelse
</div>