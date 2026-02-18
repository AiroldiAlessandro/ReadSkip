@extends('layouts.standardpage')
@section('content')
    {{-- $slug --}}
    <div class="flex flex-col sm:flex-row w-full">
        <!-- <div class="w-full sm:w-1/3  p-4"> -->
        <div class="w-full sm:w-1/3 p-4 sm:sticky sm:top-4 self-start">

            <div class="flex justify-center">
                @php
                    $cover_obj = $book->cover()->first();
                    if($cover_obj){
                        $cover_path = asset('storage/' . $cover_obj->path);
                    }else{
                        $cover_path = asset('images/insight_1.png');
                    }
                @endphp
                <img src="{{ $cover_path }}" alt="Immagine descrittiva" class="rounded-xl w-[220px]">
            </div>
            <div class="flex justify-center">
                <div class="w-64">
                    <a class="w-full justify-center flex items-center gap-2 bg-primary text-white px-6 py-3 rounded-full hover:bg-primary/80 transition mt-5" href="/read/{{ $slug }}">
                        <svg xmlns="http://www.w3.org/2000/svg" style="height:22px" viewBox="0 0 640 640"><!--!Font Awesome Free v7.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path fill="#ffffff" d="M64 480L64 184C64 170.7 74.7 160 88 160C101.3 160 112 170.7 112 184L112 472C112 485.3 122.7 496 136 496C149.3 496 160 485.3 160 472L160 160C160 124.7 188.7 96 224 96L512 96C547.3 96 576 124.7 576 160L576 480C576 515.3 547.3 544 512 544L128 544C92.7 544 64 515.3 64 480zM224 192L224 256C224 273.7 238.3 288 256 288L320 288C337.7 288 352 273.7 352 256L352 192C352 174.3 337.7 160 320 160L256 160C238.3 160 224 174.3 224 192zM248 432C234.7 432 224 442.7 224 456C224 469.3 234.7 480 248 480L488 480C501.3 480 512 469.3 512 456C512 442.7 501.3 432 488 432L248 432zM224 360C224 373.3 234.7 384 248 384L488 384C501.3 384 512 373.3 512 360C512 346.7 501.3 336 488 336L248 336C234.7 336 224 346.7 224 360zM424 240C410.7 240 400 250.7 400 264C400 277.3 410.7 288 424 288L488 288C501.3 288 512 277.3 512 264C512 250.7 501.3 240 488 240L424 240z"/></svg>                       
                        <span>Leggi</span>
                    </a>
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <a class="w-full justify-center flex items-center gap-2 bg-white text-primary border border-primary px-6 py-3 rounded-full hover:bg-primary/80 transition mt-5">
                                <svg xmlns="http://www.w3.org/2000/svg" style="height:22px" class="fill-current" viewBox="0 0 640 640"><!--!Font Awesome Free v7.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M352 96C352 78.3 337.7 64 320 64C302.3 64 288 78.3 288 96L288 306.7L246.6 265.3C234.1 252.8 213.8 252.8 201.3 265.3C188.8 277.8 188.8 298.1 201.3 310.6L297.3 406.6C309.8 419.1 330.1 419.1 342.6 406.6L438.6 310.6C451.1 298.1 451.1 277.8 438.6 265.3C426.1 252.8 405.8 252.8 393.3 265.3L352 306.7L352 96zM160 384C124.7 384 96 412.7 96 448L96 480C96 515.3 124.7 544 160 544L480 544C515.3 544 544 515.3 544 480L544 448C544 412.7 515.3 384 480 384L433.1 384L376.5 440.6C345.3 471.8 294.6 471.8 263.4 440.6L206.9 384L160 384zM464 440C477.3 440 488 450.7 488 464C488 477.3 477.3 488 464 488C450.7 488 440 477.3 440 464C440 450.7 450.7 440 464 440z"/></svg>                                
                                <span>Salva</span>
                            </a>
                        </div>
                        <div>
                            <a class="w-full justify-center flex items-center bg-white text-primary border border-primary px-6 py-3 rounded-full hover:bg-primary/80 transition mt-5" href="/read/{{ $slug }}">
                                <svg xmlns="http://www.w3.org/2000/svg"  class="fill-current" viewBox="0 0 640 640"><!--!Font Awesome Free v7.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M160 288C160 199.6 231.6 128 320 128C408.4 128 480 199.6 480 288L480 325.5C470 322 459.2 320 448 320L432 320C405.5 320 384 341.5 384 368L384 496C384 522.5 405.5 544 432 544L448 544C501 544 544 501 544 448L544 288C544 164.3 443.7 64 320 64C196.3 64 96 164.3 96 288L96 448C96 501 139 544 192 544L208 544C234.5 544 256 522.5 256 496L256 368C256 341.5 234.5 320 208 320L192 320C180.8 320 170 321.9 160 325.5L160 288z"/></svg>                                
                                <span>Ascolta</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="w-full sm:w-2/3 p-4">
            <h1 class="text-5xl font-bold text-black mt-5">
                {{ $book->title }}
            </h1>
            <p class="text-sm text-gray-700 mb-6 mt-5">
                {{ $book->author }}
            </p>
            <p class="text-gray-700 mb-6 mt-5 text-justify">
                {{ $book->long_description }}
            </p>
            <div class="flex items-center gap-2 mt-4 mb-4">
                <img src="{{ asset('images/time.png') }}" alt="time" class="h-6 w-6 rounded-xl">
                <p class="text-xl">
                    {{$book->read_time}} <span class="text-sm">min</span>
                </p>
            </div>
                   
            @auth
                @php
                    $user = auth()->user();
                    $subscription = $user->subscription('default');
                    $isSubscribed = $subscription && ($subscription->active() || $subscription->onGracePeriod());
                @endphp

                @if($isSubscribed)
                    <hr>
                    <!-- Shorts -->
                    @include('partials.book-detail.shorts-preview', [
                        'title' => 'Shorts',
                        'subtitle' => 'Gli shorts ti aiutano a imparare qualcosa di nuovo ogni giorno.',
                        'shorts' => $shorts
                    ])
                    <hr>
                    @include('partials.book-detail.chapters', [
                        'keys' => $chapters,
                        'book_id' => $slug
                    ])
                    <hr>
                    <div class="max-w-7xl mx-auto px-4 pt-7">
                        <p class="text-2xl font-bold text-black">Autore</p>
                        <p class="text-gray-700 mb-6 mt-5">
                            {{ $book->author }}
                        </p>
                    </div>
                    <div class="max-w-7xl mx-auto px-4 pt-7">
                        <p class="text-2xl font-bold text-black">Categoria</p>
                        <p class="text-gray-700 mb-6 mt-5">
                            {{ $book->category.', '.$book->sub_category }}
                        </p>
                    </div>

                @else
                    {{-- Banner per abbonarsi --}}
                    @include('partials.subscription-request.banner1')
                @endif
            @endauth

            @guest
                @include('partials.login-request.banner1')
            @endguest
            {{-- 
            @include('partials.book-detail.more-details', [
            'keys' => [
                    ['title' => 'L\'Autore', 'content' => $book->author],
                    ['title' => 'Categoria', 'content' => $book->category.', '.$book->sub_category],
                ]
            ])  --}}

        </div>
    </div>
    <!-- Nuovi libri -->
    @include('partials.home.books-preview', [
            'title' => 'Nuovi Libri',
            'subtitle' => 'Gli ultimi libri aggiunti alla nostra libreria',
            'books' => $last_books
        ])
@endsection