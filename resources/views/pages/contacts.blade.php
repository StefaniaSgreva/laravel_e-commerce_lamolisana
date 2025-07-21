@extends('layouts.app')

@section('page-title', 'Contatti - La Molisana')

@section('content')
<div class="min-h-screen">
    <!-- Hero Section -->
    <section class="bg-molisana-blue text-white py-16 md:py-24">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-6">Contattaci</h1>
            <p class="text-xl max-w-3xl mx-auto">
                Siamo qui per rispondere alle tue domande e ascoltare i tuoi feedback
            </p>
        </div>
    </section>

    <!-- Contact Content -->
    <div class="container mx-auto px-4 py-12">
        <div class="flex flex-col lg:flex-row gap-12">
            <!-- Contact Form -->
            <div class="lg:w-1/2">
                <div class="bg-white rounded-lg shadow-md p-6 md:p-8">
                    <h2 class="text-2xl font-bold text-molisana-dark-orange mb-6">Scrivici un messaggio</h2>

                    <form action="{{ route('contactsmail') }}" method="POST" class="space-y-6" id="contact-form">
                        @csrf

                        <!-- Campo Nome -->
                        <div>
                            <label for="nome" class="block text-gray-700 font-medium mb-2">Nome e Cognome *</label>
                            <input type="text" id="nome" name="nome" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-molisana-orange focus:border-transparent"
                                value="{{ old('nome') }}">
                            @error('nome')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Campo Email -->
                        <div>
                            <label for="email" class="block text-gray-700 font-medium mb-2">Email *</label>
                            <input type="email" id="email" name="email" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-molisana-orange focus:border-transparent"
                                value="{{ old('email') }}">
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Campo Telefono -->
                        <div>
                            <label for="telefono" class="block text-gray-700 font-medium mb-2">Telefono</label>
                            <input type="tel" id="telefono" name="telefono"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-molisana-orange focus:border-transparent"
                                value="{{ old('telefono') }}">
                            @error('telefono')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Campo Oggetto -->
                        <div>
                            <label for="oggetto" class="block text-gray-700 font-medium mb-2">Oggetto *</label>
                            <select id="oggetto" name="oggetto" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-molisana-orange focus:border-transparent">
                                <option value="" disabled {{ old('oggetto') ? '' : 'selected' }}>Seleziona un'opzione</option>
                                <option value="informazioni" {{ old('oggetto') == 'informazioni' ? 'selected' : '' }}>Informazioni prodotti</option>
                                <option value="distributore" {{ old('oggetto') == 'distributore' ? 'selected' : '' }}>Diventa distributore</option>
                                <option value="feedback" {{ old('oggetto') == 'feedback' ? 'selected' : '' }}>Feedback</option>
                                <option value="altro" {{ old('oggetto') == 'altro' ? 'selected' : '' }}>Altro</option>
                            </select>
                            @error('oggetto')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Campo Messaggio -->
                        <div>
                            <label for="messaggio" class="block text-gray-700 font-medium mb-2">Messaggio *</label>
                            <textarea id="messaggio" name="messaggio" rows="5" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-molisana-orange focus:border-transparent">{{ old('messaggio') }}</textarea>
                            @error('messaggio')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Privacy -->
                        <div class="flex items-center">
                            <input type="checkbox" id="accettazione_privacy" name="accettazione_privacy" value="1" required
                                class="mr-2 rounded text-molisana-orange focus:ring-molisana-orange"
                                {{ old('accettazione_privacy') ? 'checked' : '' }}>
                            <label for="accettazione_privacy" class="text-gray-700 text-sm">
                                Acconsento al trattamento dei miei dati personali secondo la <a href="#" class="text-molisana-blue hover:underline">Privacy Policy</a>
                            </label>
                        </div>
                        @error('accettazione_privacy')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror

                        <!-- Messaggi di stato -->
                        @if(session('success'))
                            <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if($errors->any() && !$errors->has('nome') && !$errors->has('email') && !$errors->has('telefono') && !$errors->has('oggetto') && !$errors->has('messaggio') && !$errors->has('accettazione_privacy'))
                            <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg">
                                Si è verificato un errore durante l'invio. Riprova più tardi.
                            </div>
                        @endif

                        <button type="submit"
                                class="w-full bg-molisana-orange hover:bg-molisana-orange-hover text-white font-bold py-3 px-4 rounded-md transition-colors">
                            Invia Messaggio
                        </button>
                    </form>
                </div>
            </div>

            <!-- Contact Info -->
            <div class="lg:w-1/2">
                <div class="bg-white rounded-lg shadow-md p-6 md:p-8 h-full">
                    <h2 class="text-2xl font-bold text-molisana-dark-orange mb-6">Dove trovarci</h2>

                    <div class="space-y-6">
                        <!-- Address -->
                        <div class="flex items-start">
                            <div class="text-molisana-orange text-xl mr-4 mt-1">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-molisana-blue mb-1">Sede Operativa</h3>
                                <p class="text-gray-700">
                                    Via della Pasta, 123<br>
                                    86100 Campobasso (CB)<br>
                                    Italia
                                </p>
                            </div>
                        </div>

                        <!-- Contacts -->
                        <div class="flex items-start">
                            <div class="text-molisana-orange text-xl mr-4 mt-1">
                                <i class="fas fa-phone-alt"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-molisana-blue mb-1">Contatti</h3>
                                <p class="text-gray-700">
                                    Tel: +39 0874 123456<br>
                                    Fax: +39 0874 654321<br>
                                    Email: info@lamolisana.it
                                </p>
                            </div>
                        </div>

                        <!-- Opening Hours -->
                        <div class="flex items-start">
                            <div class="text-molisana-orange text-xl mr-4 mt-1">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-molisana-blue mb-1">Orari Ufficio</h3>
                                <p class="text-gray-700">
                                    Lunedì-Venerdì: 8:30 - 13:00 / 14:30 - 18:00<br>
                                    Sabato: 8:30 - 13:00<br>
                                    Domenica: Chiuso
                                </p>
                            </div>
                        </div>

                        <!-- Map -->
                        <div class="mt-8 rounded-lg overflow-hidden">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3012.3456789012345!2d14.123456!3d41.123456!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNDHCsDA3JzI0LjUiTiAxNMKwMDcnMjQuNSJF!5e0!3m2!1sen!2sit!4v1234567890123!5m2!1sen!2sit"
                                    width="100%"
                                    height="300"
                                    style="border:0;"
                                    allowfullscreen=""
                                    loading="lazy"
                                    class="rounded-lg shadow-sm"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <section class="bg-molisana-dark-orange text-white py-12">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold mb-6">Hai bisogno di aiuto?</h2>
            <p class="text-xl mb-8 max-w-2xl mx-auto">
                Il nostro team è pronto ad assisterti per qualsiasi domanda o richiesta
            </p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="tel:+390874123456"
                   class="bg-white text-molisana-dark-orange hover:bg-gray-100 px-6 py-3 rounded-md font-bold transition-colors">
                    <i class="fas fa-phone-alt mr-2"></i> Chiama Ora
                </a>
                <a href="mailto:info@lamolisana.it"
                   class="border border-white text-white hover:bg-white hover:text-molisana-dark-orange px-6 py-3 rounded-md font-bold transition-colors">
                    <i class="fas fa-envelope mr-2"></i> Invia Email
                </a>
            </div>
        </div>
    </section>
</div>
@endsection
