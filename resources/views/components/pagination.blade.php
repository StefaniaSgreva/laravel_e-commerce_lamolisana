@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Navigazione pagine" class="my-8">
        {{-- Mobile --}}
        <div class="flex justify-between items-center sm:hidden">
            @if ($paginator->onFirstPage())
                <span class="px-4 py-2 rounded-full bg-gray-100 text-gray-400 cursor-not-allowed">
                    &laquo; Precedente
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="px-4 py-2 rounded-full bg-molisana-blue text-white hover:bg-molisana-orange transition-colors">
                    &laquo; Precedente
                </a>
            @endif

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="px-4 py-2 rounded-full bg-molisana-blue text-white hover:bg-molisana-orange transition-colors">
                    Successivo &raquo;
                </a>
            @else
                <span class="px-4 py-2 rounded-full bg-gray-100 text-gray-400 cursor-not-allowed">
                    Successivo &raquo;
                </span>
            @endif
        </div>

        {{-- Desktop --}}
        <div class="hidden sm:flex items-center justify-between">
            <div class="text-sm text-gray-600">
                Elementi da
                <span class="font-bold text-molisana-blue">{{ $paginator->firstItem() }}</span>
                a
                <span class="font-bold text-molisana-blue">{{ $paginator->lastItem() }}</span>
                di
                <span class="font-bold text-molisana-orange">{{ $paginator->total() }}</span>
                totali
            </div>

            <div class="flex items-center space-x-1">
                {{-- Previous --}}
                @if ($paginator->onFirstPage())
                    <span class="p-2 rounded-full bg-gray-100 text-gray-400 cursor-not-allowed">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                    </span>
                @else
                    <a href="{{ $paginator->previousPageUrl() }}" class="p-2 rounded-full bg-molisana-blue text-white hover:bg-molisana-orange transition-colors">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                    </a>
                @endif

                {{-- Pages --}}
                @foreach ($elements as $element)
                    @if (is_string($element))
                        <span class="px-3 py-1 text-gray-400">...</span>
                    @endif

                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <span class="flex items-center justify-center w-10 h-10 rounded-full bg-molisana-orange text-white font-bold">
                                    {{ $page }}
                                </span>
                            @else
                                <a href="{{ $url }}" class="flex items-center justify-center w-10 h-10 rounded-full text-molisana-blue hover:bg-molisana-blue hover:text-white transition-colors">
                                    {{ $page }}
                                </a>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                {{-- Next --}}
                @if ($paginator->hasMorePages())
                    <a href="{{ $paginator->nextPageUrl() }}" class="p-2 rounded-full bg-molisana-blue text-white hover:bg-molisana-orange transition-colors">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                        </svg>
                    </a>
                @else
                    <span class="p-2 rounded-full bg-gray-100 text-gray-400 cursor-not-allowed">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                        </svg>
                    </span>
                @endif
            </div>
        </div>
    </nav>
@endif
