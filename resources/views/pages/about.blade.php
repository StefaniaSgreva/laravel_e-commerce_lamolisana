@extends('layouts.app')

@section('page-title', 'Chi Siamo - La Molisana')

@section('content')
<div class="min-h-screen">
    <!-- Hero Section -->
    <section class="bg-molisana-blue text-white py-16 md:py-24">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-6">La Nostra Storia</h1>
            <p class="text-xl max-w-3xl mx-auto">
                Dal 1912, portiamo sulle vostre tavole la vera tradizione molisana
            </p>
        </div>
    </section>

    <!-- Content Sections -->
    <div class="container mx-auto px-4 py-12">
        <!-- Storia -->
        <section class="mb-16">
            <div class="flex flex-col md:flex-row gap-8 items-center">
                <div class="md:w-1/2">
                    <img src="{{ Vite::asset('resources/img/pastificio_home.jpg') }}"
                         alt="Fabbrica storica La Molisana"
                         class="rounded-lg shadow-lg w-full">
                </div>
                <div class="md:w-1/2">
                    <h2 class="text-3xl font-bold text-molisana-dark-orange mb-4">Le Nostre Radici</h2>
                    <p class="text-gray-700 mb-4">
                        Fondata nel cuore del Molise, La Molisana nasce dalla passione per la pasta trafilata al bronzo
                        e dall'amore per il territorio. Dal piccolo pastificio artigianale siamo cresciuti mantenendo
                        intatta la qualità delle origini.
                    </p>
                    <p class="text-gray-700">
                        Oggi come allora, utilizziamo solo grani 100% italiani e tecniche di lavorazione che rispettano
                        i tempi naturali della pasta.
                    </p>
                </div>
            </div>
        </section>

        <!-- Valori -->
        <section class="mb-16">
            <h2 class="text-3xl font-bold text-center text-molisana-dark-orange mb-12">I Nostri Valori</h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Qualità -->
                <div class="bg-white p-6 rounded-lg shadow-md border border-gray-100 text-center hover:shadow-lg transition-shadow">
                    <div class="text-molisana-orange text-4xl mb-4">
                        <i class="fas fa-award"></i>
                    </div>
                    <h3 class="text-xl font-bold text-molisana-blue mb-2">Qualità</h3>
                    <p class="text-gray-600">
                        Selezione rigorosa delle materie prime e controllo costante in ogni fase di produzione
                    </p>
                </div>

                <!-- Tradizione -->
                <div class="bg-white p-6 rounded-lg shadow-md border border-gray-100 text-center hover:shadow-lg transition-shadow">
                    <div class="text-molisana-orange text-4xl mb-4">
                        <i class="fas fa-history"></i>
                    </div>
                    <h3 class="text-xl font-bold text-molisana-blue mb-2">Tradizione</h3>
                    <p class="text-gray-600">
                        Tecniche artigianali tramandate da generazioni per una pasta dal sapore autentico
                    </p>
                </div>

                <!-- Innovazione -->
                <div class="bg-white p-6 rounded-lg shadow-md border border-gray-100 text-center hover:shadow-lg transition-shadow">
                    <div class="text-molisana-orange text-4xl mb-4">
                        <i class="fas fa-lightbulb"></i>
                    </div>
                    <h3 class="text-xl font-bold text-molisana-blue mb-2">Innovazione</h3>
                    <p class="text-gray-600">
                        Ricerca continua per migliorare i processi mantenendo inalterata la bontà del prodotto finale
                    </p>
                </div>
            </div>
        </section>

        <!-- Team -->
        <section>
            <h2 class="text-3xl font-bold text-center text-molisana-dark-orange mb-12">Il Nostro Team</h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach([
                    ['name' => 'Giovanni Rossi', 'role' => 'Direttore Generale', 'img' => 'user_m_2.jpg'],
                    ['name' => 'Maria Bianchi', 'role' => 'Responsabile Qualità', 'img' => 'user_f_2.jpg'],
                    ['name' => 'Luigi Verdi', 'role' => 'Capo Produzione', 'img' => 'user_m_1.jpg'],
                    ['name' => 'Anna Neri', 'role' => 'Responsabile Commerciale', 'img' => 'user_f_1.jpg']
                ] as $member)
                <div class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-shadow">
                    <div class="w-full h-84 overflow-hidden">
                        <img src="{{ Vite::asset('resources/img/team/' . $member['img']) }}"
                            alt="{{ $member['name'] }}"
                            class="object-fit-cover ob">
                        </div>
                    <div class="p-4">
                        <h3 class="text-xl font-bold text-molisana-blue">{{ $member['name'] }}</h3>
                        <p class="text-molisana-dark-orange font-medium">{{ $member['role'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </section>
    </div>

    <!-- CTA Section -->
    <section class="bg-molisana-dark-orange text-white py-12">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold mb-6">Vuoi saperne di più?</h2>
            <p class="text-xl mb-8 max-w-2xl mx-auto">
                Scopri la nostra gamma di prodotti o contattaci per maggiori informazioni
            </p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="{{ route('products') }}"
                   class="bg-white text-molisana-dark-orange hover:bg-gray-100 px-6 py-3 rounded-md font-bold transition-colors">
                    I Nostri Prodotti
                </a>
                <a href="{{ route('contacts') }}"
                   class="border border-white text-white hover:bg-white hover:text-molisana-dark-orange px-6 py-3 rounded-md font-bold transition-colors">
                    Contattaci
                </a>
            </div>
        </div>
    </section>
</div>
@endsection
