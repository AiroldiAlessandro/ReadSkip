<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Libro: '.$book->title) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-5">
                <form method="POST" action="" enctype="multipart/form-data">
                    @csrf
                    <label for="title" class="mt-2">Titolo</label>
                    <input type="text" class="w-full" name="title" value="{{ $book->title }}" id="title">

                    <label for="author" class="mt-2">Autore</label>
                    <input type="text" class="w-full" name="author" value="{{ $book->author }}" id="author">

                    <label for="cover">Copertina</label>
                    <input type="file" class="w-full" name="cover" id="cover">

                    @if ($book->cover)
                        <img src="{{ asset('storage/' . $book->cover->path) }}" class="h-80" alt="">
                    @endif

                    <label for="status" class="mt-2">Stato</label><br>
                    <select name="status" id="status">
                        <option value="0" @if ($book->status == 0) selected @endif>Bozza</option>
                        <option value="1" @if ($book->status == 1) selected @endif>Pubblicato</option>
                    </select><br>

                    <label for="read_time" class="mt-2">Tempo di lettura</label>
                    <input type="text" class="w-full" name="read_time" value="{{ $book->read_time }}" id="read_time">

                    <label for="category" class="mt-2">Categoria</label>
                    <input type="text" class="w-full" name="category" value="{{ $book->category }}" id="category">

                    <label for="sub_category" class="mt-2">Sotto categoria</label>
                    <input type="text" class="w-full" name="sub_category" value="{{ $book->sub_category }}" id="sub_category">

                    <label for="short_description" class="mt-2">Descrizione corta</label>
                    <input type="text" class="w-full" name="short_description" value="{{ $book->short_description }}" id="short_description">

                    <label for="long_description" class="mt-2">Descrizione lunga</label>
                    <textarea class="w-full" name="long_description" id="long_description" cols="30" rows="10">{{ $book->long_description }}</textarea>

                    <div class="flex justify-between mt-4">
                        <button class="bg-red-500 text-white px-4 py-2 rounded" id="delete_book" type="button">Elimina libro</button>
                        <a class="bg-green-500 text-white px-4 py-2 rounded" href="{{ route('admin.chaptersdetail', $book->id) }}">
                            Mostra capitoli
                        </a>
                        <button class="bg-blue-500 text-white px-4 py-2 rounded" type="submit">Salva</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#delete_book').click(function(){
                if(!confirm('Sei sicuro di voler eliminare il libro {{ $book->title }} ?')) return;
                window.location.href = '{{ route('admin.deletebook', $book->id) }}';
            });
        });

    </script>
</x-app-layout>
