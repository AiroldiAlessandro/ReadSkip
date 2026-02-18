<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Capitoli libro: '.$book->title) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-5">
                <form method="POST" action="{{ route('admin.updatechapters', ['id' => $book->id]) }}" enctype="multipart/form-data">
                    @csrf
                    @foreach ($chapters as $key => $chapter)
                        <h1 class="text-xl font-bold text-black mt-5">Capitolo {{ $key }}</h1>
                        <label for="title" class="mt-2">Titolo</label>
                        <input type="text" class="w-full" value="{{ $chapter->title }}" name="chapters[{{ $chapter->id }}][title]">
                        <label for="short_summary" class="mt-2">Riassunto corto</label>
                        <textarea name="chapters[{{ $chapter->id }}][short_summary]" class="w-full" cols="30" rows="10">{{$chapter->short_summary}}</textarea>
                        <label for="long_summary" class="mt-2">Riassunto lungo</label>
                        <textarea name="chapters[{{ $chapter->id }}][long_summary]" class="w-full" cols="30" rows="10">{{$chapter->long_summary}}</textarea>
                        <label for="short" class="mt-2">Short</label>
                        <textarea name="chapters[{{ $chapter->id }}][short]" class="w-full" cols="30" rows="2">{{$chapter->short}}</textarea>
                        <label for="relevant_quote" class="mt-2">Citazione</label>
                        <textarea name="chapters[{{ $chapter->id }}][relevant_quote]" class="w-full" cols="30" rows="2">{{$chapter->relevant_quote}}</textarea>
                        <label for="questions_and_answers" class="mt-2">Domande risposta multipla (json)</label>
                        <textarea name="chapters[{{ $chapter->id }}][questions_and_answers]" class="w-full" cols="30" rows="10">{{$chapter->questions_and_answers}}</textarea>
                        <label for="open_questions_and_answers" class="mt-2">Domande risposta aperta (json)</label>
                        <textarea name="chapters[{{ $chapter->id }}][open_questions_and_answers]" class="w-full" cols="30" rows="10">{{$chapter->open_questions_and_answers}}</textarea>
                        
                        <label for="audio" class="mt-2">Audio Capitolo</label>
                        @if ($chapter->audio_path)
                            <p class="text-sm text-gray-500 mb-1">
                                Audio attuale: <a href="{{ asset('storage/' . $chapter->audio_path) }}" target="_blank" class="text-blue-600 underline">ascolta</a>
                            </p>
                        @endif
                        <input type="file" name="chapters[{{ $chapter->id }}][audio]" accept="audio/*" class="w-full border p-2">

                        <label for="email_object" class="mt-2">Oggetto email</label>
                        <input type="text" class="w-full" value="{{ $chapter->email_object }}" name="chapters[{{ $chapter->id }}][email_object]">
                        
                        <label for="email_body" class="mt-2">Corpo email</label>
                        <textarea name="chapters[{{ $chapter->id }}][email_body]" class="w-full" cols="30" rows="10">{{$chapter->email_body}}</textarea>

                        <hr class="h-px my-8 bg-gray-200 border-0">
                    @endforeach
                    <div class="flex justify-end">
                        <button class="bg-blue-500 text-white px-4 py-2 rounded" type="submit">Salva</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {

        });

    </script>
</x-app-layout>
