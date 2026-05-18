@if ($paginator->hasPages())
    <nav class="flex items-center justify-center space-x-2 mt-12 mb-8" aria-label="Pagination">
        @if ($paginator->onFirstPage())
            <span class="px-4 py-2 rounded-md bg-[#0b1b2b] text-gray-600 cursor-not-allowed border border-white/5 shadow-inner">
                &laquo; Prev
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="px-4 py-2 rounded-md bg-[#0b1b2b] text-gray-300 border border-white/10 hover:border-[#4b76c4] hover:text-[#4b76c4] hover:shadow-[0_0_15px_rgba(75,118,196,0.5)] transition-all duration-300 ease-in-out transform hover:-translate-y-1">
                &laquo; Prev
            </a>
        @endif

        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="px-4 py-2 text-gray-500">{{ $element }}</span>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="px-4 py-2 rounded-md bg-gradient-to-r from-[#4b76c4] to-[#3a5a96] text-white font-bold shadow-[0_0_15px_rgba(75,118,196,0.7)] transform scale-110 transition-all duration-300 cursor-default">
                            {{ $page }}
                        </span>
                    @else
                        <a href="{{ $url }}" class="px-4 py-2 rounded-md bg-[#0b1b2b] text-gray-400 border border-transparent hover:border-white/20 hover:text-white transition-all duration-300 ease-in-out hover:bg-white/10">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach
            @endif
        @endforeach

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="px-4 py-2 rounded-md bg-[#0b1b2b] text-gray-300 border border-white/10 hover:border-[#4b76c4] hover:text-[#4b76c4] hover:shadow-[0_0_15px_rgba(75,118,196,0.5)] transition-all duration-300 ease-in-out transform hover:-translate-y-1">
                Next &raquo;
            </a>
        @else
            <span class="px-4 py-2 rounded-md bg-[#0b1b2b] text-gray-600 cursor-not-allowed border border-white/5 shadow-inner">
                Next &raquo;
            </span>
        @endif
    </nav>
@endif
