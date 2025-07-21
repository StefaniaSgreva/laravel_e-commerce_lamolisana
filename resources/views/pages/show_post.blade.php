@extends('layouts.app')

@section('page-title', $post->meta_title ?? $post->titolo . ' - Blog La Molisana')

@section('meta-description', $post->meta_description ?? Str::limit(strip_tags($post->contenuto), 160))

@section('content')
<div class="container mx-auto px-4 py-12 max-w-5xl">
    <!-- Breadcrumb -->
    <nav class="mb-8 text-sm text-gray-600" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('home') }}" class="inline-flex items-center hover:text-molisana-blue">
                    Home
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-4 h-4 mx-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <a href="{{ route('blog') }}" class="ml-1 hover:text-molisana-blue">Blog</a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="w-4 h-4 mx-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="ml-1 font-medium text-gray-500 md:ml-2">{{ $post->titolo }}</span>
                </div>
            </li>
        </ol>
    </nav>

    <!-- Header articolo -->
    <header class="mb-12">
        <!-- Categoria -->
        @if($post->categoria)
        <div class="mb-4">
            <a href="#"
               class="inline-block px-3 py-1 text-sm font-semibold text-molisana-blue bg-blue-50 rounded-full hover:bg-blue-100">
                {{ $post->categoria->nome }}
            </a>
        </div>
        @endif

        <!-- Titolo -->
        <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4 leading-tight">
            {{ $post->titolo }}
        </h1>

        <!-- Meta informazioni -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 text-gray-500 text-sm">
            <!-- Autore e data -->
            <div class="flex items-center space-x-4">
                <div class="flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <span>{{ $post->data_pubblicazione->format('d/m/Y') }}</span>
                </div>
                <div class="flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>{{ $post->tempo_lettura }} min di lettura</span>
                </div>
                <div class="flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    <span>{{ $post->visualizzazioni }} visualizzazioni</span>
                </div>
            </div>

            <!-- Condivisione social -->
            <div class="flex items-center space-x-4">
                <span class="hidden sm:inline">Condividi:</span>
                <div class="flex space-x-2">
                    <a href="#" class="text-gray-400 hover:text-molisana-blue">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"></path>
                        </svg>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-molisana-blue">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/>
                        </svg>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-molisana-blue">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"></path>
                        </svg>
                    </a>
                </div>
            </div>
    </header>

    <!-- Immagine in evidenza -->
    @if($post->immagine_copertina)
    <div class="mb-12 rounded-lg overflow-hidden border-3 bg-gray-100">
        <img src="{{ Vite::asset('resources/img/products/' . $post->immagine_copertina) }}"
             alt="{{ $post->titolo }}"
             class="w-full h-auto max-h-96 object-cover"
             loading="lazy">
    </div>
    @endif

    <!-- Contenuto articolo -->
    <article class="prose prose-lg max-w-none">
        {!! $post->contenuto !!}
    </article>

    <!-- Navigazione articoli -->
    <div class="mt-12 pt-8 border-t border-gray-200">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            @if($previousPost)
            <a href="{{ route('posts.show', $previousPost->slug) }}" class="group">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2 text-gray-400 group-hover:text-molisana-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    <div>
                        <span class="text-sm text-gray-500">Precedente</span>
                        <h3 class="font-medium text-gray-900 group-hover:text-molisana-blue">{{ $previousPost->titolo }}</h3>
                    </div>
                </div>
            </a>
            @endif

            @if($nextPost)
            <a href="{{ route('posts.show', $nextPost->slug) }}" class="group md:text-right">
                <div class="flex items-center md:justify-end">
                    <div>
                        <span class="text-sm text-gray-500">Successivo</span>
                        <h3 class="font-medium text-gray-900 group-hover:text-molisana-blue">{{ $nextPost->titolo }}</h3>
                    </div>
                    <svg class="w-5 h-5 ml-2 text-gray-400 group-hover:text-molisana-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </div>
            </a>
            @endif
        </div>
    </div>

    <!-- Articoli correlati (della stessa categoria) -->
    @if($relatedPosts->isNotEmpty())
    <div class="mt-16">
        <h2 class="text-2xl font-bold text-gray-900 mb-8">Altri articoli in {{ $post->categoria->nome }}</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($relatedPosts as $related)
                @include('components.related_post_card', ['post' => $related])
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection
