<x-admin::layout.app>


    <div class="space-y-6">

        {{-- Header --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <h1 class="text-2xl font-semibold text-gray-900">
                    Media Library
                </h1>

                <p class="mt-1 text-sm text-gray-500">
                    Manage images, documents, videos and other media files.
                </p>
            </div>

            <div>
                <a href="{{ route('media.create') }}"
                    class="inline-flex items-center gap-2 rounded-lg bg-gray-900 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-gray-800">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>

                    Upload Media
                </a>
            </div>

        </div>


        {{-- Toolbar --}}
        <div class="rounded-xl border border-gray-200 bg-white p-4">

            <form method="GET" action="{{ route('media.index') }}" class="flex flex-col gap-3 lg:flex-row">

                {{-- Search --}}
                <div class="relative flex-1">

                    <svg class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m21 21-4.35-4.35m1.35-5.65a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
                    </svg>

                    <input type="search" name="search" value="{{ request('search') }}" placeholder="Search media..."
                        class="w-full rounded-lg border border-gray-300 bg-white py-2.5 pl-10 pr-4 text-sm text-gray-900 outline-none transition placeholder:text-gray-400 focus:border-gray-500 focus:ring-1 focus:ring-gray-500">

                </div>


                {{-- Type --}}
                <select name="type"
                    class="rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-700 outline-none focus:border-gray-500 focus:ring-1 focus:ring-gray-500">
                    <option value="">All types</option>
                    <option value="image" @selected(request('type') === 'image')>
                        Images
                    </option>
                    <option value="video" @selected(request('type') === 'video')>
                        Videos
                    </option>
                    <option value="audio" @selected(request('type') === 'audio')>
                        Audio
                    </option>
                    <option value="application" @selected(request('type') === 'application')>
                        Documents
                    </option>
                </select>


                {{-- Search button --}}
                <button type="submit"
                    class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-sm font-medium text-gray-700 transition hover:bg-gray-50">
                    Filter
                </button>


                {{-- Clear --}}
                @if(request()->hasAny(['search', 'type']))
                    <a href="{{ route('media.index') }}"
                        class="inline-flex items-center justify-center rounded-lg px-4 py-2.5 text-sm font-medium text-gray-500 transition hover:bg-gray-100 hover:text-gray-700">
                        Clear
                    </a>
                @endif

            </form>

        </div>


        {{-- Media Library --}}
        @if($media->count())

            <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6">

                @foreach($media as $item)

                    <div
                        class="group overflow-hidden rounded-xl border border-gray-200 bg-white transition hover:border-gray-300 hover:shadow-sm">

                        {{-- Preview --}}
                        <div class="relative aspect-square overflow-hidden bg-gray-100">

                            {{-- Selection --}}
                            <div class="absolute left-3 top-3 z-10">
                                <input type="checkbox" value="{{ $item->uuid }}"
                                    class="h-4 w-4 rounded border-gray-300 text-gray-900 focus:ring-gray-500">
                            </div>


                            {{-- Image --}}
                            @if($item->isImage())

                                <img src="{{ $item->url }}" alt="{{ $item->alt_text ?: $item->title ?: $item->original_filename }}"
                                    class="h-full w-full object-cover transition duration-300 group-hover:scale-105" loading="lazy">

                                {{-- Video --}}
                            @elseif($item->isVideo())

                                <div class="flex h-full w-full items-center justify-center">

                                    <div class="flex h-14 w-14 items-center justify-center rounded-full bg-white shadow-sm">
                                        <svg class="ml-1 h-6 w-6 text-gray-700" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M8 5v14l11-7z" />
                                        </svg>
                                    </div>

                                </div>

                                {{-- Audio --}}
                            @elseif($item->isAudio())

                                <div class="flex h-full w-full flex-col items-center justify-center gap-3">

                                    <div class="flex h-14 w-14 items-center justify-center rounded-full bg-white">
                                        <svg class="h-7 w-7 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                                d="M9 18V5l10-2v13" />
                                            <circle cx="6" cy="18" r="3" />
                                            <circle cx="16" cy="16" r="3" />
                                        </svg>
                                    </div>

                                    <span class="text-xs font-medium uppercase text-gray-500">
                                        Audio
                                    </span>

                                </div>

                                {{-- Document --}}
                            @elseif($item->isDocument())

                                <div class="flex h-full w-full flex-col items-center justify-center gap-3">

                                    <div class="flex h-14 w-14 items-center justify-center rounded-lg bg-white shadow-sm">
                                        <svg class="h-7 w-7 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                                d="M6 3h9l5 5v13H6z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M14 3v6h6" />
                                        </svg>
                                    </div>

                                    <span class="text-xs font-medium uppercase text-gray-500">
                                        {{ $item->extension }}
                                    </span>

                                </div>

                                {{-- Other --}}
                            @else

                                <div class="flex h-full w-full flex-col items-center justify-center gap-3">

                                    <div class="flex h-14 w-14 items-center justify-center rounded-lg bg-white shadow-sm">
                                        <svg class="h-7 w-7 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                                d="M7 3h7l5 5v13H7z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M14 3v6h5" />
                                        </svg>
                                    </div>

                                    <span class="text-xs font-medium uppercase text-gray-500">
                                        File
                                    </span>

                                </div>

                            @endif


                            {{-- Hover actions --}}
                            <div
                                class="absolute inset-x-0 bottom-0 flex translate-y-full items-center justify-between bg-black/70 px-3 py-2 transition-transform group-hover:translate-y-0">

                                <a href="{{ route('media.show', $item->uuid) }}"
                                    class="text-xs font-medium text-white hover:underline">
                                    View
                                </a>

                                <form method="POST" action="{{ route('media.destroy', $item->uuid) }}"
                                    onsubmit="return confirm('Are you sure you want to delete this media?')">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="text-xs font-medium text-white hover:underline">
                                        Delete
                                    </button>
                                </form>

                            </div>

                        </div>


                        {{-- Details --}}
                        <div class="p-3">

                            <div class="truncate text-sm font-medium text-gray-900">
                                {{ $item->title ?: $item->original_filename }}
                            </div>

                            <div class="mt-1 flex items-center justify-between gap-2">

                                <span class="truncate text-xs text-gray-500">
                                    {{ strtoupper($item->extension ?: 'file') }}
                                </span>

                                <span class="shrink-0 text-xs text-gray-400">
                                    {{ number_format($item->size / 1024, 1) }} KB
                                </span>

                            </div>

                        </div>

                    </div>

                @endforeach

            </div>


            {{-- Pagination --}}
            @if($media->hasPages())

                <div class="rounded-xl border border-gray-200 bg-white px-4 py-3">
                    {{ $media->withQueryString()->links() }}
                </div>

            @endif

        @else

            {{-- Empty state --}}
            <div class="rounded-xl border border-dashed border-gray-300 bg-white px-6 py-16 text-center">

                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-gray-100">

                    <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M4 16l4.5-5 3.5 4 2.5-3 5.5 6M5 20h14a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2 2 2 0 0 0 2-2V6a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2Z" />
                    </svg>

                </div>

                <h3 class="mt-4 text-base font-semibold text-gray-900">
                    No media found
                </h3>

                <p class="mx-auto mt-1 max-w-md text-sm text-gray-500">
                    Upload images, documents, videos and other files to start building your media library.
                </p>

                <div class="mt-6">

                    <a href="{{ route('media.create') }}"
                        class="inline-flex items-center gap-2 rounded-lg bg-gray-900 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-gray-800">
                        Upload Media
                    </a>

                </div>

            </div>

        @endif

    </div>

</x-admin::layout.app>