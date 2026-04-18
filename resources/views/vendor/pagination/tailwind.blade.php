<nav class="flex flex-wrap items-center justify-between gap-3 mt-6" role="navigation">

    {{-- Results count --}}
    <p class="text-sm text-gray-500">
        @if($paginator->total() > 0)
            Showing <span class="font-semibold text-gray-700">{{ $paginator->firstItem() ?? 1 }}</span>
            – <span class="font-semibold text-gray-700">{{ $paginator->lastItem() ?? $paginator->total() }}</span>
            of <span class="font-semibold text-gray-700">{{ $paginator->total() }}</span> results
        @else
            No results found
        @endif
    </p>

    {{-- Page buttons --}}
    <div class="flex items-center gap-1 flex-wrap">

        {{-- Previous --}}
        @if ($paginator->onFirstPage())
            <span class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-bold text-gray-300 bg-gray-100 border border-gray-200 rounded-lg cursor-not-allowed select-none">
                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                Prev
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev"
               class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-bold text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-purple-50 hover:border-purple-400 hover:text-purple-700 transition">
                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                Prev
            </a>
        @endif

        {{-- Page numbers --}}
        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="px-2 py-1.5 text-xs text-gray-400 select-none">…</span>
            @endif
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="inline-flex items-center justify-center w-8 h-8 text-xs font-bold text-white bg-purple-900 rounded-lg shadow-sm select-none">
                            {{ $page }}
                        </span>
                    @else
                        <a href="{{ $url }}"
                           class="inline-flex items-center justify-center w-8 h-8 text-xs font-bold text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-purple-50 hover:border-purple-400 hover:text-purple-700 transition">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next"
               class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-bold text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-purple-50 hover:border-purple-400 hover:text-purple-700 transition">
                Next
                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>
            </a>
        @else
            <span class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-bold text-gray-300 bg-gray-100 border border-gray-200 rounded-lg cursor-not-allowed select-none">
                Next
                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>
            </span>
        @endif

    </div>
</nav>
