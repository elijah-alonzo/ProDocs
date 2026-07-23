<div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl p-6 shadow-sm">

    <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-6">
        Submission Timeline
    </h3>

    {{-- Empty state: no stages configured --}}
    @if ($timelineEntries->isEmpty())
        <div class="flex flex-col items-center justify-center py-8 text-center">
            <x-heroicon-o-queue-list class="w-10 h-10 text-gray-200 dark:text-gray-700 mb-2" />
            <p class="text-sm text-gray-400 dark:text-gray-500">No stages configured for this process.</p>
        </div>
    @else
        <div class="relative">

            {{-- Vertical connector line --}}
            <div class="absolute left-4 top-0 bottom-0 w-px bg-gray-200 dark:bg-gray-700"></div>

            <ul class="space-y-6">
                @foreach ($timelineEntries as $entry)
                    @php
                        $key      = $entry['stage']->id . ':' . $entry['cycle'];
                        $state    = $entry['state'];
                        $stage    = $entry['stage'];
                        $approval = $entry['approval'];
                        $isExpanded = $expandedEntry === $key;

                        $iconColor = match ($state) {
                            'approved' => 'text-success-500 dark:text-success-400',
                            'rejected' => 'text-danger-500 dark:text-danger-400',
                            'current'  => 'text-primary-500 dark:text-primary-400',
                            default    => 'text-gray-300 dark:text-gray-600',
                        };

                        $ringColor = match ($state) {
                            'approved' => 'ring-success-500 dark:ring-success-400',
                            'rejected' => 'ring-danger-500 dark:ring-danger-400',
                            'current'  => 'ring-primary-500 dark:ring-primary-400',
                            default    => 'ring-gray-200 dark:ring-gray-700',
                        };

                        $labelColor = match ($state) {
                            'approved' => 'text-success-600 dark:text-success-400',
                            'rejected' => 'text-danger-600 dark:text-danger-400',
                            'current'  => 'text-primary-600 dark:text-primary-400',
                            default    => 'text-gray-400 dark:text-gray-500',
                        };

                        $stateLabel = match ($state) {
                            'approved' => 'Approved',
                            'rejected' => 'Rejected',
                            'current'  => 'In Progress',
                            default    => 'Pending',
                        };
                    @endphp

                    <li class="relative flex gap-4 pl-2">

                        {{-- Icon --}}
                        <div @class([
                            'relative z-10 flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-white dark:bg-gray-900 ring-2',
                            $ringColor,
                            'cursor-pointer hover:opacity-80 transition-opacity' => $approval !== null,
                        ])
                            @if ($approval !== null)
                                wire:click="toggleEntry('{{ $key }}')"
                            @endif
                        >
                            @if ($state === 'approved')
                                <x-heroicon-s-check-circle class="w-5 h-5 {{ $iconColor }}" />
                            @elseif ($state === 'rejected')
                                <x-heroicon-s-x-circle class="w-5 h-5 {{ $iconColor }}" />
                            @elseif ($state === 'current')
                                <x-heroicon-s-ellipsis-horizontal-circle class="w-5 h-5 {{ $iconColor }}" />
                            @else
                                <x-heroicon-o-clock class="w-5 h-5 {{ $iconColor }}" />
                            @endif
                        </div>

                        {{-- Content --}}
                        <div class="flex-1 min-w-0 pb-1">

                            {{-- Stage name + attempt badge --}}
                            <div class="flex items-center gap-2 flex-wrap">
                                <p @class([
                                    'text-sm font-medium',
                                    'text-gray-900 dark:text-white'    => $state !== 'pending',
                                    'text-gray-400 dark:text-gray-500' => $state === 'pending',
                                ])>
                                    {{ $stage->stage_name }}
                                </p>

                                @if ($entry['cycle'] > 1)
                                    <span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-500 dark:bg-gray-800 dark:text-gray-400">
                                        Attempt {{ $entry['cycle'] }}
                                    </span>
                                @endif
                            </div>

                            {{-- State label + timestamp --}}
                            <p class="mt-0.5 text-xs font-medium {{ $labelColor }}">
                                {{ $stateLabel }}
                                @if ($approval)
                                    &middot; {{ $approval->acted_at->format('M d, Y g:i A') }}
                                @endif
                            </p>

                            {{-- Expandable detail --}}
                            @if ($approval !== null && $isExpanded)
                                <div class="mt-3 rounded-lg bg-gray-50 dark:bg-gray-800 border border-gray-100 dark:border-gray-700 p-3 space-y-2 text-sm">
                                    <div class="flex items-center gap-2 text-gray-600 dark:text-gray-300">
                                        <x-heroicon-o-user class="w-4 h-4 shrink-0 text-gray-400" />
                                        <span class="font-medium">{{ $approval->user->full_name }}</span>
                                    </div>
                                    @if (filled($approval->remarks))
                                        <div class="flex gap-2 text-gray-600 dark:text-gray-300">
                                            <x-heroicon-o-chat-bubble-left-ellipsis class="w-4 h-4 shrink-0 mt-0.5 text-gray-400" />
                                            <p class="leading-relaxed">{{ $approval->remarks }}</p>
                                        </div>
                                    @else
                                        <p class="text-gray-400 dark:text-gray-500 italic text-xs">No remarks provided.</p>
                                    @endif
                                </div>
                            @endif

                            {{-- Click hint --}}
                            @if ($approval !== null && ! $isExpanded)
                                <p class="mt-1 text-xs text-gray-400 dark:text-gray-500 cursor-pointer hover:text-primary-500 transition-colors"
                                   wire:click="toggleEntry('{{ $key }}')">
                                    View details &darr;
                                </p>
                            @endif

                        </div>
                    </li>
                @endforeach
            </ul>

        </div>
    @endif

</div>