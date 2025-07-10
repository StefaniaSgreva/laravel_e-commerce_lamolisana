@extends('layouts.app')

@section('page-title', 'Blog - La Molisana')

@section('content')
<div class="container mx-auto px-4 py-12">
    <header class="mb-12 text-center">
        <h1 class="text-4xl font-bold text-molisana-blue mb-4">Il nostro Blog</h1>
        <p class="text-xl text-gray-700 max-w-3xl mx-auto">
            Scopri articoli, ricette e novità dal mondo della pasta di qualità
        </p>
    </header>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($posts as $post)
        <article class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-shadow duration-300">
            <!-- Immagine del post -->
            <div class="relative pb-[56.25%] overflow-hidden">
                <img
                    src="{{ $post['img'] }}"
                    alt="{{ $post['title'] }}"
                    class="absolute h-full w-full object-cover"
                    loading="lazy"
                >
            </div>

            <!-- Contenuto del post -->
            <div class="p-6">
                <h2 class="text-2xl font-bold text-molisana-dark-orange mb-3">
                    {{ $post['title'] }}
                </h2>

                <p class="text-gray-600 mb-4 line-clamp-3">
                    {{ $post['body'] }}
                </p>

                <a href="#"
                   class="inline-flex items-center text-molisana-blue font-semibold hover:underline">
                    Leggi tutto
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                    </svg>
                </a>
            </div>

            <!-- Footer della card -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                <div class="flex items-center text-sm text-gray-500">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <span>Pubblicato il {{ now()->format('d/m/Y') }}</span>
                </div>
            </div>
        </article>
        @endforeach
    </div>
</div>
@endsection
