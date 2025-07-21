<div class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-shadow duration-300 flex flex-col h-full">
    <!-- Immagine del post -->
    <div class="relative pb-[56.25%] overflow-hidden">
        @if($post->immagine_copertina)
        <img src="{{ Vite::asset('resources/img/products/' . $post->immagine_copertina) }}"
             alt="{{ $post->titolo }}"
             class="absolute h-full w-full object-cover"
             loading="lazy">
        @else
        <div class="absolute inset-0 bg-gray-200 flex items-center justify-center">
            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
        </div>
        @endif
    </div>

    <!-- Contenuto del post -->
    <div class="p-6 flex-grow">
        @if($post->categoria)
        <div class="mb-3">
            <span class="inline-block px-2 py-1 text-xs font-semibold text-molisana-blue bg-blue-50 rounded-full">
                {{ $post->categoria->nome }}
            </span>
        </div>
        @endif

        <h3 class="text-xl font-bold text-gray-900 mb-3">
            <a href="{{ route('posts.show', $post->slug) }}" class="hover:text-molisana-dark-orange">
                {{ $post->titolo }}
            </a>
        </h3>

        <p class="text-gray-600 mb-4 line-clamp-3">
            {{ $post->estratto ?? Str::limit(strip_tags($post->contenuto), 150) }}
        </p>

        <a href="{{ route('posts.show', $post->slug) }}"
           class="inline-flex items-center text-molisana-blue font-semibold hover:underline">
            Leggi tutto
            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
            </svg>
        </a>
    </div>

    <!-- Footer della card -->
    <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 mt-auto">
        <div class="flex items-center text-sm text-gray-500">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            <span>{{ $post->data_pubblicazione ? $post->data_pubblicazione->format('d/m/Y') : $post->created_at->format('d/m/Y') }}</span>
        </div>
    </div>
</div>
