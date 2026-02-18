@extends('layouts.standardpage')
@section('content')
    <h1 class="text-5xl font-bold text-center text-black">
        Ciao, come 
        <span class="text-primary">posso aiutarti</span>
        oggi?
    </h1>
    <!-- Search -->
    <form class="max-w-4xl mx-auto mt-20" method="get" >   
        <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only">Search</label>
        <div class="relative">
            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                </svg>
            </div>
            <input type="search" id="default-search" name="search" class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-full bg-gray-50 focus:ring-blue-500 focus:border-blue-500" placeholder="" value="{{ $search_text }}" />
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
    <!-- Libri -->
    @php
    $title = 'Gli ultimi libri';
    $subtitle = 'Gli ultimi libri aggiunti alla nostra libreria';
    if($search_text){
        if(count($all_books) > 1){
            $title = count($all_books).' Risultati';
        }else{
            $title = count($all_books).' Risultato';
        }
        $subtitle = 'Ricerca per: '.$search_text;
    }
    @endphp
    @include('partials.books.books-preview', [
            'title' => $title,
            'subtitle' => $subtitle,
            'books' => $all_books,
            'search_text' => $search_text
        ])
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
