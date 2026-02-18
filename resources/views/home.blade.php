@extends('layouts.standardpage')
@section('content')
    <h1 class="text-5xl font-bold text-center text-black">
        Ciao, come 
        <span class="text-primary">posso aiutarti</span>
        oggi?
    </h1>
    <!-- Search -->
    <form class="max-w-4xl mx-auto mt-20" method="get" action="{{ route('books') }}">   
        <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only">Search</label>
        <div class="relative">
            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                </svg>
            </div>
            <input type="search" id="default-search" name="search" class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-full bg-gray-50 focus:ring-blue-500 focus:border-blue-500" placeholder="" />
            <button type="submit" class="text-white absolute end-2.5 bottom-2.5 bg-primary hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-full text-sm px-4 py-2 ">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </button>
        </div>
    </form>
    <!-- Main Category -->
    <div class="flex justify-center space-x-2 mt-5 mb-5">
        <a class="bg-white text-gray-700 px-4 py-2 rounded-full border border-gray-300 hover:bg-gray-100" href="{{ route('books', ['search' => 'Produttività']) }}">Produttività</a>
        <a class="bg-white text-gray-700 px-4 py-2 rounded-full border border-gray-300 hover:bg-gray-100" href="{{ route('books', ['search' => 'Leadership']) }}">Leadership</a>
        <a class="bg-white text-gray-700 px-4 py-2 rounded-full border border-gray-300 hover:bg-gray-100" href="{{ route('books', ['search' => 'Psicologia']) }}">Psicologia</a>
    </div>
    <!-- Info banner -->
    <div class="max-w-7xl mx-auto px-4 py-12 mt-10 sm:mt-20">
        <div class="grid grid-cols-1 md:grid-cols-2 items-center gap-8">
            <!-- Colonna sinistra: testo -->
            <div>
                <button class="bg-gray-200 text-black px-2 py-1 rounded-md">
                    Benevenuti su <span class="text-primary">Readskip</span>
                </button>
                <h1 class="text-4xl font-bold text-black mt-5">
                    Impara dai
                    <span class="text-primary">migliori libri</span>
                    al mondo
                </h1>
                <p class="text-gray-700 mb-6 mt-5">
                    Ottieni spunti essenziali da migliaia di bestseller in soli 15 minuti. Leggi o ascolta ovunque, in qualsiasi momento.
                </p>

                <div class="flex space-x-4 mt-5">
                    <div class="flex space-x-2">
                        <svg width="22" height="23" viewBox="0 0 22 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M21.3315 19.49L16.7321 2.32162C16.49 1.44558 15.7006 0.813167 14.763 0.813167C14.5764 0.813167 14.3965 0.838344 14.2247 0.884998L14.2388 0.882035L12.0935 1.45668C11.8528 1.52629 11.6425 1.63145 11.4566 1.7677L11.4625 1.764C11.0997 1.18121 10.4636 0.799097 9.7371 0.796875H7.517C6.93273 0.797616 6.40621 1.04643 6.03743 1.44335L6.03595 1.44484C5.66569 1.04717 5.13917 0.798356 4.5549 0.797616H2.33332C1.2092 0.799097 0.298356 1.70994 0.296875 2.83406V20.6067C0.298356 21.7308 1.2092 22.6416 2.33332 22.6431H4.5549C5.13917 22.6416 5.66569 22.3936 6.03447 21.9966L6.03595 21.9952C6.40621 22.3936 6.93273 22.6416 7.517 22.6431H9.7371C10.8612 22.6416 11.7721 21.7308 11.7735 20.6067V8.1303L15.2533 21.1191C15.4954 21.9944 16.2841 22.6261 17.2201 22.6276C17.2209 22.6276 17.2223 22.6276 17.2238 22.6276C17.4097 22.6276 17.5896 22.6024 17.7607 22.555L17.7466 22.5587L19.8927 21.9848C20.768 21.7434 21.4004 20.954 21.4004 20.0172C21.4004 19.8306 21.3752 19.6492 21.3278 19.4774L21.3315 19.4914V19.49ZM12.637 7.06098L16.5692 6.00721L19.3484 16.3798L15.4155 17.4328L12.637 7.06098ZM12.38 2.53045L14.5246 1.9558C14.5964 1.9358 14.6794 1.92396 14.7653 1.92396C15.1911 1.92396 15.5495 2.21202 15.6569 2.60376L15.6583 2.61042L16.2811 4.93493L12.3482 5.9887L11.7721 3.83747V3.05622C11.8854 2.79926 12.1046 2.60672 12.3734 2.53193L12.38 2.53045ZM7.51626 1.9084H9.73636C10.2473 1.90914 10.6613 2.3231 10.662 2.83406V5.24003L6.5906 5.24077V2.83406C6.59134 2.3231 7.0053 1.90914 7.51626 1.9084ZM5.47982 17.0892H1.40692V6.35156L5.47982 6.35082V17.0892ZM6.5906 6.35156L10.662 6.35082V17.0892H6.5906V6.35156ZM2.33258 1.9084H4.55416C5.06512 1.90914 5.47907 2.3231 5.47982 2.83406V5.24003L1.40692 5.24077V2.83406C1.40766 2.3231 1.82162 1.90914 2.33258 1.9084ZM4.55416 21.5323H2.33258C1.82162 21.5316 1.40766 21.1176 1.40692 20.6067V18.2H5.47982V20.6067C5.47907 21.1176 5.06512 21.5316 4.55416 21.5323ZM9.73636 21.5323H7.51626C7.0053 21.5316 6.59134 21.1176 6.5906 20.6067V18.2H10.662V20.6067C10.6613 21.1176 10.2473 21.5316 9.73636 21.5323ZM20.1644 20.4778C20.043 20.6889 19.846 20.8444 19.6113 20.9088L19.6046 20.9103L17.4586 21.4842C17.3875 21.5035 17.306 21.5146 17.2223 21.5146C16.7965 21.5146 16.4374 21.228 16.3278 20.837L16.3263 20.8303L15.7035 18.5051L19.6364 17.452L20.2592 19.7773C20.2792 19.8484 20.2903 19.9306 20.2903 20.015C20.2903 20.1853 20.2437 20.3453 20.1622 20.4815L20.1644 20.4778Z" fill="#405DE6"/>
                        </svg> 
                        5,000+ Libri
                    </div>
                    <div class="flex space-x-2">
                        <svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M16.4169 21.6078V19.6331C16.4169 18.5856 16.0008 17.581 15.2601 16.8404C14.5195 16.0997 13.5149 15.6836 12.4674 15.6836H6.54322C5.49576 15.6836 4.49119 16.0997 3.75052 16.8404C3.00985 17.581 2.59375 18.5856 2.59375 19.6331V21.6078" stroke="#405DE6" stroke-width="1.97474" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M9.50806 11.731C11.6893 11.731 13.4575 9.96274 13.4575 7.7815C13.4575 5.60027 11.6893 3.83203 9.50806 3.83203C7.32683 3.83203 5.55859 5.60027 5.55859 7.7815C5.55859 9.96274 7.32683 11.731 9.50806 11.731Z" stroke="#405DE6" stroke-width="1.97474" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M22.3449 21.6044V19.6297C22.3443 18.7546 22.053 17.9046 21.5169 17.2129C20.9807 16.5213 20.2301 16.0274 19.3828 15.8086" stroke="#405DE6" stroke-width="1.97474" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M16.4219 3.96094C17.2714 4.17846 18.0244 4.67253 18.5621 5.36528C19.0999 6.05803 19.3917 6.91004 19.3917 7.78699C19.3917 8.66394 19.0999 9.51595 18.5621 10.2087C18.0244 10.9014 17.2714 11.3955 16.4219 11.613" stroke="#405DE6" stroke-width="1.97474" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        2M+ Lettori
                    </div>
                    <div class="flex space-x-2">
                        <svg width="23" height="22" viewBox="0 0 23 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10.7541 2.13492C10.7974 2.0475 10.8642 1.97391 10.9471 1.92246C11.03 1.87101 11.1256 1.84375 11.2231 1.84375C11.3207 1.84375 11.4163 1.87101 11.4991 1.92246C11.582 1.97391 11.6488 2.0475 11.6921 2.13492L13.9729 6.75481C14.1232 7.05889 14.345 7.32196 14.6193 7.52146C14.8936 7.72095 15.2122 7.8509 15.5478 7.90016L20.6485 8.64661C20.7452 8.66061 20.836 8.70138 20.9107 8.7643C20.9853 8.82722 21.0409 8.90979 21.0711 9.00266C21.1013 9.09553 21.105 9.195 21.0816 9.28982C21.0582 9.38463 21.0087 9.47101 20.9388 9.53919L17.25 13.1312C17.0067 13.3683 16.8247 13.6609 16.7196 13.984C16.6145 14.307 16.5895 14.6507 16.6467 14.9855L17.5176 20.0606C17.5346 20.1572 17.5242 20.2566 17.4875 20.3476C17.4507 20.4385 17.3892 20.5173 17.3098 20.575C17.2304 20.6326 17.1364 20.6668 17.0386 20.6736C16.9407 20.6804 16.8429 20.6596 16.7563 20.6135L12.1967 18.2162C11.8962 18.0584 11.562 17.976 11.2226 17.976C10.8833 17.976 10.549 18.0584 10.2486 18.2162L5.6899 20.6135C5.60334 20.6593 5.50566 20.6799 5.40796 20.673C5.31026 20.6661 5.21648 20.6318 5.13727 20.5742C5.05806 20.5166 4.9966 20.4379 4.9599 20.3471C4.92319 20.2563 4.9127 20.157 4.92963 20.0606L5.7995 14.9865C5.85696 14.6515 5.83207 14.3076 5.72697 13.9844C5.62186 13.6611 5.43971 13.3684 5.19622 13.1312L1.50741 9.54018C1.43691 9.47208 1.38695 9.38555 1.36322 9.29045C1.33949 9.19534 1.34295 9.09548 1.37321 9.00225C1.40346 8.90902 1.45929 8.82615 1.53434 8.7631C1.60939 8.70005 1.70064 8.65934 1.7977 8.64562L6.89745 7.90016C7.23341 7.85128 7.55246 7.7215 7.82714 7.52198C8.10182 7.32247 8.32391 7.05919 8.47428 6.75481L10.7541 2.13492Z" stroke="#405DE6" stroke-width="1.97474" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        4.8 Valutazione
                    </div>
                </div>
                <button class="bg-primary text-white px-6 py-3 rounded-full hover:bg-primary/80 transition mt-5">
                    Prova Readskip gratis
                </button>
            </div>
            <!-- Colonna destra: immagine -->
            <div class="flex justify-center">
                <img src="{{ asset('images/girl-wp.png') }}" alt="Immagine descrittiva" class="rounded-xl">
            </div>
        </div>
    </div>
    <hr>
    <!-- Insight banner -->
    <div class="max-w-7xl mx-auto px-4 py-12 mt-20">
        <div class="grid grid-cols-1 md:grid-cols-2 items-center gap-8">
            <!-- Colonna sinistra: testo -->
            <div class="flex justify-center">
                <img src="{{ $insight['image'] }}" alt="Immagine descrittiva" class="rounded-xl h-80">
            </div>
            <!-- Colonna destra: immagine -->
            <div>
                <button class="bg-secondary text-black px-2 py-1 rounded-md">
                    Insight di oggi
                </button>
                <h1 class="text-4xl font-bold text-black mt-5">
                    {{$insight['time']}} Minuti di Lettura
                </h1>
                <p class="text-sm text-gray-700 mb-6 mt-5">
                    Inizia la giornata con una potente intuizione
                </p>
                <p class="text-gray-700 mb-6 mt-5">
                    Da "{{$insight['title']}}": {{$insight['subtitle']}}
                </p>
                <button class="bg-primary text-white px-6 py-3 rounded-full hover:bg-primary/80 transition mt-5" onclick="window.location.href='/book/{{ $insight['id'] }}'">
                    Per saperne di più
                </button>
            </div>
            
        </div>
    </div>
    <!-- Shorts -->
{{-- 
    @include('partials.home.shorts-preview', [
        'title' => 'Shorts',
        'subtitle' => 'Gli shorts ti aiutano a imparare qualcosa di nuovo ogni giorno. Fai presto, il set di oggi scompare a mezzanotte.',
        'books' => [
                ['title_1' => 'Find your time again', 'title_2' => 'Titolo del Libro', 'subtitle' => 'How to improve your relationship with people', 'time' => '21'],
                ['title_1' => 'Find your time again', 'title_2' => 'Titolo del Libro', 'subtitle' => 'How to improve your relationship with people', 'time' => '21'],
                ['title_1' => 'Find your time again', 'title_2' => 'Titolo del Libro', 'subtitle' => 'How to improve your relationship with people', 'time' => '21'],
                ['title_1' => 'Find your time again', 'title_2' => 'Titolo del Libro', 'subtitle' => 'How to improve your relationship with people', 'time' => '21'],
                ['title_1' => 'Find your time again', 'title_2' => 'Titolo del Libro', 'subtitle' => 'How to improve your relationship with people', 'time' => '21'],
                ['title_1' => 'Find your time again', 'title_2' => 'Titolo del Libro', 'subtitle' => 'How to improve your relationship with people', 'time' => '21'],
                ['title_1' => 'Find your time again', 'title_2' => 'Titolo del Libro', 'subtitle' => 'How to improve your relationship with people', 'time' => '21'],
                ['title_1' => 'Find your time again', 'title_2' => 'Titolo del Libro', 'subtitle' => 'How to improve your relationship with people', 'time' => '21'],
                ['title_1' => 'Find your time again', 'title_2' => 'Titolo del Libro', 'subtitle' => 'How to improve your relationship with people', 'time' => '21'],
            ]
        ])

--}}
    <!-- Continua con -->
    @if(count($reading_books) > 0)
        @include('partials.home.books-preview', [
                'title' => 'Continua con',
                'subtitle' => 'Riprendi i libri che hai iniziato da dove eri rimasto',
                'books' => $reading_books
            ])
    @endif
    <!-- Nuovi libri -->
    @include('partials.home.books-preview', [
            'title' => 'Nuovi Libri',
            'subtitle' => 'Gli ultimi libri aggiunti alla nostra libreria',
            'books' => $last_books
        ])
    <!-- Info banner pre footer-->
    <div class="max-w-7xl mx-auto px-4 py-12 mt-20">
        <div class="grid grid-cols-1 md:grid-cols-2 items-center gap-8">
            <!-- Colonna sinistra -->
            <div class="flex justify-center">
                <img src="{{ asset('images/girl-wp-2.png') }}" alt="Immagine descrittiva" class="rounded-xl">
            </div>
            <!-- Colonna destra -->
            <div>
                <h1 class="text-4xl font-bold text-black mt-5">
                    Accelera il tuo apprendimento con i migliori riassunti di libri al mondo
                </h1>
                <p class="text-gray-700 mb-6 mt-5">
                    Unisciti a milioni di lettori che stanno già trasformando la loro vita.
                </p>
                <button class="bg-primary text-white px-6 py-3 rounded-full hover:bg-primary/80 transition mt-5">
                    Prova Readskip gratis
                </button>
            </div>
        </div>
    </div>
    <script>
        function updatePlaceholder() {
            const input = document.getElementById('default-search');
            if (window.innerWidth < 640) {
                // Mobile (sm breakpoint di Tailwind)
                input.placeholder = 'Cosa vorresti imparare oggi?';
            } else {
                input.placeholder = 'Cosa vorresti imparare oggi? (es: gestione del tempo, leadership...)';
            }
        }
        // Esegui al primo caricamento
        updatePlaceholder();
        // Esegui quando cambia la dimensione della finestra
        window.addEventListener('resize', updatePlaceholder);
    </script>
@endsection
