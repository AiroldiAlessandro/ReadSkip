<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

use App\Models\Cover;
use App\Models\Book;
use App\Http\Controllers\AdminController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
/* 
    - Titlo, Autore /import-book
    - Titlo, Descrizione_Lunga_Libro, Descrizione_Breve_Libro /import-book
    - Titlo, Categoria_Libro, Sottosezione_Libro /import-book
    - Titolo, File /upload-cover
    - Titolo, File, Capitolo /upload-audio
    


*/
Route::match(['get', 'post'], '/import-book', function (Request $request) {

    Log::channel('api')->info('Richiesta ricevuta:', [
        'method' => $request->method(),
        'ip' => $request->ip(),
        'headers' => $request->headers->all(),
        'data' => $request->all(),
    ]);

    $validator = Validator::make($request->all(), [
        'titolo' => 'required|string',
        'titolo_Capitolo' => 'string',
        'autore' => 'string',
        'capitolo' => 'string',
        'riassunto_lungo_capitolo' => 'string',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'message' => 'Errore di validazione',
            'errors' => $validator->errors(),
        ], 422);
    }
    $title = $request->input('titolo');
    if ($request->input('autore')) {
        $author = $request->input('autore');
        $book = Book::whereRaw('LOWER(title) = ? AND LOWER(author) = ?', [
                strtolower($title),
                strtolower($author),
            ])->first();

        if(!$book){
            $book = Book::create([
                'title' => $title,
                'author' => $author,
                'read_time' => 10,
                'status' => false
            ]);
        }else{
            $book->title = $title;
            $book->author = $author;
            $book->save();
        }
    }else if($request->input('capitolo')){
        $book = Book::whereRaw('LOWER(title) = ?', [
            strtolower($title),
        ])->first();
        if(!$book){
            return response()->json([
                'message' => 'libro non trovato',
                'errors' => $validator->errors(),
            ], 422);
        }

        $chapter_title = $request->input('capitolo');
        /* Rami del capitolo */
        if ($request->input('riassunto_lungo_capitolo')) {
            $long_summary = $request->input('riassunto_lungo_capitolo');
            $book->chapters()->create([
                'title' => $chapter_title,
                'long_summary' =>  $long_summary,
            ]);
        }else if($request->input('riassunto_corto_capitolo')){
            $chapter = $book->chapters()->whereRaw('LOWER(title) = ?', [
                strtolower($chapter_title),
            ])->first();
            if(!$chapter){
                return response()->json([
                    'message' => 'Capitolo non trovato',
                    'errors' => $validator->errors(),
                ], 422);
            }
            $short_summary = $request->input('riassunto_corto_capitolo');
            $chapter->short_summary = $short_summary;
            $chapter->save();
        }else if($request->input('json_domande_capitolo')){
            $chapter = $book->chapters()->whereRaw('LOWER(title) = ?', [
                strtolower($chapter_title),
            ])->first();
            if(!$chapter){
                return response()->json([
                    'message' => 'Capitolo non trovato',
                    'errors' => $validator->errors(),
                ], 422);
            }
            $questions_and_answers = $request->input('json_domande_capitolo');
            $chapter->questions_and_answers = $questions_and_answers;
            $chapter->save();
        }else if($request->input('json_domande')){
            $chapter = $book->chapters()->whereRaw('LOWER(title) = ?', [
                strtolower($chapter_title),
            ])->first();
            if(!$chapter){
                return response()->json([
                    'message' => 'Capitolo non trovato',
                    'errors' => $validator->errors(),
                ], 422);
            }
            $open_questions_and_answers = $request->input('json_domande');
            $chapter->open_questions_and_answers = $open_questions_and_answers;
            $chapter->save();
        }else if($request->input('citazione_capitolo')){
            $chapter = $book->chapters()->whereRaw('LOWER(title) = ?', [
                strtolower($chapter_title),
            ])->first();
            if(!$chapter){
                return response()->json([
                    'message' => 'Capitolo non trovato',
                    'errors' => $validator->errors(),
                ], 422);
            }
            $relevant_quote = $request->input('citazione_capitolo');
            $chapter->relevant_quote = $relevant_quote;
            $chapter->save();
        }else if($request->input('short')){
            $chapter = $book->chapters()->whereRaw('LOWER(title) = ?', [
                strtolower($chapter_title),
            ])->first();
            if(!$chapter){
                return response()->json([
                    'message' => 'Capitolo non trovato',
                    'errors' => $validator->errors(),
                ], 422);
            }
            $short = $request->input('short');
            $chapter->short = $short;
            $chapter->save();
        }else if($request->input('json_emailfollowup_capitolo')){
            $chapter = $book->chapters()->whereRaw('LOWER(title) = ?', [
                strtolower($chapter_title),
            ])->first();
            if(!$chapter){
                return response()->json([
                    'message' => 'Capitolo non trovato',
                    'errors' => $validator->errors(),
                ], 422);
            }
            $json_emailfollowup_capitolo = $request->input('json_emailfollowup_capitolo');
            $json_emailfollowup_capitolo = str_replace('oggetto email', 'oggetto_email', $json_emailfollowup_capitolo);
            $json_emailfollowup_capitolo = str_replace('testo email', 'testo_email', $json_emailfollowup_capitolo);
            $json_emailfollowup_capitolo = str_replace('\\n', '<br>', $json_emailfollowup_capitolo);
            $json = json_decode($json_emailfollowup_capitolo);

            $chapter->email_object = $json->oggetto_email;
            $chapter->email_body = $json->testo_email.'<br><br>'. $json->Firma;
            
            $chapter->save();
        }
    }else if($request->input('sottosezione_libro') && $request->input('categoria_libro')){
        $book = Book::whereRaw('LOWER(title) = ?', [
            strtolower($title),
        ])->first();
        if(!$book){
            return response()->json([
                'message' => 'Libro non trovato',
                'errors' => $validator->errors(),
            ], 422);
        }
        $book->category = $request->input('categoria_libro');
        $book->sub_category = $request->input('sottosezione_libro');
        $book->save();
    }else if($request->input('descrizione_lunga_libro') && $request->input('descrizione_breve_libro')){
        $book = Book::whereRaw('LOWER(title) = ?', [
            strtolower($title),
        ])->first();
        if(!$book){
            return response()->json([
                'message' => 'Libro non trovato',
                'errors' => $validator->errors(),
            ], 422);
        }
        $book->short_description = $request->input('descrizione_breve_libro');
        $book->long_description = $request->input('descrizione_lunga_libro');
        $book->save();
    }

    return response()->json([
        'status' => 'received',
        'method' => $request->method(),
        'data' => $request->all(),
    ]);
});

Route::match(['post'], '/upload-audio', function (Request $request) {
    Log::channel('api')->info('Richiesta ricevuta:', [
        'method' => $request->method(),
        'ip' => $request->ip(),
        'headers' => $request->headers->all(),
        'data' => $request->all(),
    ]);
    
    $ip = $request->ip();

    $validator = Validator::make($request->all(), [
        'titolo' => 'required|string|max:255',
        'capitolo' => 'required|string|max:255',
        'file' => 'required|file|max:5120|mimetypes:audio/mpeg,audio/mp3,audio/wav,audio/x-wav,audio/ogg',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'message' => 'Errore di validazione',
            'errors' => $validator->errors(),
        ], 422);
    }

    $title = $request->input('titolo');
    $book = Book::whereRaw('LOWER(title) = ?', [strtolower($title)])->first();
    if (!$book) {
        // Libro non trovato
        return response()->json([
            'message' => 'Libro non trovato'
        ], 404);
    }

    $chapterTitle = $request->input('capitolo');

    $chapter = $book->chapters()
        ->whereRaw('LOWER(title) = ?', [strtolower($chapterTitle)])
        ->first();

    if (!$chapter) {
        return response()->json([
            'message' => 'Capitolo non trovato'
        ], 404);
    }

    // ✅ Gestione file (multipart/form-data)
    if ($request->hasFile('file') && $request->file('file')->isValid()) {
        $file = $request->file('file');
        $path = $file->store('audio', 'public');

        Log::channel('api')->info('File cover ricevuto', [
            'ip' => $ip,
            'title' => $request->input('title'),
            'original_name' => $file->getClientOriginalName(),
            'mime_type' => $file->getMimeType(),
            'size' => $file->getSize(),
            'stored_path' => $path,
        ]);
        if ($chapter->audio_path) {
            Storage::disk('public')->delete($chapter->audio_path);
        }
        $chapter->audio_path =  $path;
        
        $chapter->save();

        return response()->json([
            'message' => 'File audio salvato',
            'path' => $path
        ]);
    }

    return response()->json([
        'message' => 'Nessun file valido trovato'
    ], 400);
});
Route::match(['post'], '/upload-cover', function (Request $request) {
    $ip = $request->ip();

    $validator = Validator::make($request->all(), [
        'titolo' => 'required|string|max:255',
        'file' => 'required|image|max:5120', // max 5MB
    ]);

    if ($validator->fails()) {
        return response()->json([
            'message' => 'Errore di validazione',
            'errors' => $validator->errors(),
        ], 422);
    }

    $title = $request->input('titolo');
    $book = Book::whereRaw('LOWER(title) = ?', [strtolower($title)])->first();
    if (!$book) {
        // Libro non trovato
        return response()->json([
            'message' => 'Libro non trovato'
        ], 404);
    }

    // ✅ Gestione file (multipart/form-data)
    if ($request->hasFile('file') && $request->file('file')->isValid()) {
        $file = $request->file('file');
        $path = $file->store('covers', 'public');

        Log::channel('api')->info('File cover ricevuto', [
            'ip' => $ip,
            'title' => $request->input('title'),
            'original_name' => $file->getClientOriginalName(),
            'mime_type' => $file->getMimeType(),
            'size' => $file->getSize(),
            'stored_path' => $path,
        ]);
        $current_cover = $book->cover()->first();
        if ($current_cover) {
            Storage::disk('public')->delete($current_cover->path);
            $current_cover->delete();
        }
        $cover = new Cover([
            'path' => $path
        ]);

        $book->cover()->save($cover);

        return response()->json([
            'message' => 'File multipart salvato',
            'path' => $path
        ]);
    }

    return response()->json([
        'message' => 'Nessun file valido trovato'
    ], 400);
});
