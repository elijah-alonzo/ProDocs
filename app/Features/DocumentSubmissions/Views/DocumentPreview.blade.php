<div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl shadow-sm overflow-hidden h-full min-h-[600px] flex flex-col">

    {{-- Header --}}
    <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100 dark:border-gray-800">
        <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">
            Document Preview
        </h3>
        @if ($fileUrl)
            <a href="{{ $fileUrl }}"
               target="_blank"
               class="inline-flex items-center gap-1.5 text-xs text-primary-600 dark:text-primary-400 hover:underline">
                <x-heroicon-o-arrow-top-right-on-square class="w-3.5 h-3.5" />
                Open
            </a>
        @endif
    </div>

    {{-- Preview Body --}}
    <div class="flex-1 flex items-center justify-center p-4">

        @if ($previewType === 'none')
            <div class="text-center space-y-3">
                <x-heroicon-o-document class="w-16 h-16 text-gray-200 dark:text-gray-700 mx-auto" />
                <p class="text-sm text-gray-400 dark:text-gray-500">No document uploaded yet.</p>
            </div>

        @elseif ($previewType === 'pdf')
            {{-- Loading skeleton shown until iframe fires onload --}}
            <div class="relative w-full min-h-[540px]">
                <div
                    id="pdf-skeleton"
                    class="absolute inset-0 flex items-center justify-center bg-gray-50 dark:bg-gray-800 rounded-lg animate-pulse"
                >
                    <div class="text-center space-y-2">
                        <x-heroicon-o-document class="w-10 h-10 text-gray-300 dark:text-gray-600 mx-auto" />
                        <p class="text-xs text-gray-400 dark:text-gray-500">Loading preview...</p>
                    </div>
                </div>
                <iframe
                    src="{{ $fileUrl }}"
                    class="relative w-full min-h-[540px] rounded-lg border border-gray-100 dark:border-gray-800 opacity-0 transition-opacity duration-300"
                    title="Document Preview"
                    onload="
                        this.style.opacity = '1';
                        document.getElementById('pdf-skeleton').style.display = 'none';
                    "
                ></iframe>
            </div>

        @elseif ($previewType === 'image')
            <img
                src="{{ $fileUrl }}"
                alt="Document Preview"
                class="max-w-full max-h-[540px] rounded-lg object-contain border border-gray-100 dark:border-gray-800"
                loading="lazy"
            />

        @else
            <div class="text-center space-y-4">
                <x-heroicon-o-paper-clip class="w-16 h-16 text-gray-200 dark:text-gray-700 mx-auto" />
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Preview not available for
                    <span class="font-medium uppercase">{{ $extension }}</span> files.
                </p>
                <a href="{{ $fileUrl }}"
                   download
                   class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-primary-600 hover:bg-primary-700 text-white text-sm font-medium transition-colors">
                    <x-heroicon-o-arrow-down-tray class="w-4 h-4" />
                    Download File
                </a>
            </div>
        @endif

    </div>

</div>