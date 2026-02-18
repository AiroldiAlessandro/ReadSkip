<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Cover;
use App\Models\Chapter;
use Illuminate\Validation\ValidationException;


class AdminController extends Controller
{
    //
    public function index(){
        return view('dashboard');
    }
    public function bookListView(){
        return view('admin.book-list');
    }
    public function bookListData(Request $request){
        $columns = ['title', 'author', 'created_at', 'status'];

        $totalData = Book::count();
        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        $query = Book::query();

        // Ricerca globale
        if (!empty($request->input('search.value'))) {
            $search = $request->input('search.value');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                  ->orWhere('author', 'LIKE', "%{$search}%")
                  ->orWhere('status', 'LIKE', "%{$search}%");
            });
            $totalFiltered = $query->count();
        }

        $books = $query->offset($start)
                       ->limit($limit)
                       ->orderBy($order, $dir)
                       ->get();

        $data = [];
        foreach ($books as $book) {
            $data[] = [
                "id" => $book->id,
                "title" => $book->title,
                "author" => $book->author,
                "created_at" => $book->created_at->format('Y-m-d'),
                "status" => $book->status,
            ];
        }

        return response()->json([
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        ]);
    }
    public function bookDetailView($id){
        $book = Book::with('cover')->findOrFail($id);

        return view('admin.book-detail', compact('book'));
    }
    public function chaptersDetailView($id){
        $book = Book::with('chapters')->findOrFail($id); // carica anche i capitoli
        $chapters = $book->chapters;

        return view('admin.chapters-detail', compact('chapters', 'book'));
    }
    public function updateBook(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'cover' => 'nullable|image|max:2048',
            'status' => 'required|in:0,1',
            'read_time' => 'nullable|string|max:50',
            'category' => 'nullable|string|max:100',
            'sub_category' => 'nullable|string|max:100',
            'short_description' => 'nullable|string|max:255',
            'long_description' => 'nullable|string',
        ]);

        $book = Book::findOrFail($id);
        $book->update($validated);

        if ($request->hasFile('cover')) {
            $path = $request->file('cover')->store('covers', 'public');
            $book->cover()->updateOrCreate([], ['path' => $path]);
        }

        return redirect()->back()->with('success', 'Libro aggiornato correttamente!');
    }
    public function updateChapters(Request $request)
    {
        logger('REQ->' . json_encode($request->all()));
    
        // 🔹 Validazione base (campi testuali + file opzionale)
        try {
            $validated = $request->validate([
                'chapters.*.title' => 'required|string|max:255',
                'chapters.*.short_summary' => 'nullable|string',
                'chapters.*.long_summary' => 'nullable|string',
                'chapters.*.short' => 'nullable|string',
                'chapters.*.relevant_quote' => 'nullable|string',
                'chapters.*.questions_and_answers' => 'nullable|string',
                'chapters.*.open_questions_and_answers' => 'nullable|string',
                'chapters.*.audio' => 'nullable|file|mimes:mp3,wav,ogg|max:10240',
                /* 'chapters.*.email_object' => 'string|max:255',
                'chapters.*.email_body' => 'string', */
            ]);
        } catch (ValidationException $e) {
            logger('ERRORE_VAL->' . json_encode($e->errors()));
            return back()->withErrors($e->errors())->withInput();
        }
    
        logger('VAL->' . json_encode($validated));
    
        foreach ($request->chapters as $id => $chapterData) {
            $chapter = Chapter::findOrFail($id);
        
            if ($request->hasFile("chapters.$id.audio")) {
                $file = $request->file("chapters.$id.audio");
                logger("UPLOAD AUDIO CHAPTER $id -> " . $file->getClientOriginalName());
        
                // Cancella il vecchio
                if ($chapter->audio_path && \Storage::disk('public')->exists($chapter->audio_path)) {
                    \Storage::disk('public')->delete($chapter->audio_path);
                }
        
                // Salva il nuovo
                $path = $file->store('audios', 'public');
                $chapter->audio_path = $path;
            }
        
            // Aggiorna i campi testuali
            $chapter->fill([
                'title' => $chapterData['title'] ?? $chapter->title,
                'short_summary' => $chapterData['short_summary'] ?? $chapter->short_summary,
                'long_summary' => $chapterData['long_summary'] ?? $chapter->long_summary,
                'short' => $chapterData['short'] ?? $chapter->short,
                'relevant_quote' => $chapterData['relevant_quote'] ?? $chapter->relevant_quote,
                'questions_and_answers' => $chapterData['questions_and_answers'] ?? $chapter->questions_and_answers,
                'open_questions_and_answers' => $chapterData['open_questions_and_answers'] ?? $chapter->open_questions_and_answers,
                'email_object' => $chapterData['email_object'] ?? $chapter->email_object,
                'email_body' => $chapterData['email_body'] ?? $chapter->email_body,
            ]);
            
            $chapter->save();
            logger('Chapter saved ->' . $chapter->id);
        }
    
        return redirect()->back()->with('success', 'Capitoli aggiornati correttamente!');
    }
    public function deleteBook($id){

        $book = Book::findOrFail($id);
        $book->delete();

        return redirect()->route('admin.booklist');
    }
}
