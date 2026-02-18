<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReadingStatus;
use App\Models\Book;

use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    public function loadHome(){
        $last_books_query = Book::where('status', 1)
            ->orderBy('created_at', 'desc') // Ordina dalla più recente alla più vecchia
            ->take(10) // Prendi solo gli ultimi 10
            ->get();
        $last_book = $last_books_query->first();

        $user = auth()->user();
        $reading_books_query=[];
        $reading_books = [];
        if ($user) {
            // 📖 Libri che l’utente sta ancora leggendo (status_percentage < 100)
            $reading_books_query = Book::whereHas('readingStatuses', function ($query) use ($user) {
                $query->where('user_id', $user->id)
                    ->where('status_percentage', '<', 100);
            })->orderByDesc(
                ReadingStatus::select('updated_at')
                    ->whereColumn('book_id', 'books.id')
                    ->where('user_id', $user->id)
                    ->latest()
                    ->take(1)
            )->get();
            // 🔹 Formattazione libri in lettura
            $reading_books = $reading_books_query->map(function ($book) {
                $cover_obj = $book->cover()->first();
                return [
                    'image' => $cover_obj ? asset('storage/' . $cover_obj->path) : asset('images/insight_1.png'),
                    'id' => $book->id,
                    'title' => $book->title,
                    'subtitle' => $book->short_description,
                    'time' => $book->read_time,
                ];
            });
        }

        $last_books = [];
        foreach ($last_books_query as $book) {
            $cover_obj = $book->cover()->first();
            $last_books[] = [
                'image' => ($cover_obj) ?  asset('storage/' . $cover_obj->path) : asset('images/insight_1.png'),
                'id' => $book->id,
                'title' => $book->title,
                'subtitle' => $book->short_description,
                'time' => $book->read_time,
            ];
        }
        
        $insight = null;
        if ($last_book) {
            $cover_obj = $last_book->cover()->first();
            $insight = [
                'image' => ($cover_obj) ? asset('storage/' . $cover_obj->path) : asset('images/insight_1.png'),
                'id' => $last_book->id,
                'title' => $last_book->title,
                'subtitle' => $last_book->short_description,
                'time' => $last_book->read_time,
            ];
        }else{
            $insight = [
                'image' => '',
                'id' => '',
                'title' => '',
                'subtitle' => '',
                'time' => '',
            ];
        }
        return view('home', [
            'last_books' => $last_books, 
            'reading_books' => $reading_books,
            'insight' => $insight
        ]);
    }
    public function loadBooksList(){
        $search = request()->query('search'); // prende il parametro 'search' dalla query string
        $booksQuery = Book::where('status', 1)
                        ->orderBy('created_at', 'desc');

        if ($search) {
            $booksQuery->where(function($query) use ($search) {
                $query->where('title', 'like', "%{$search}%")
                        ->orWhere('author', 'like', "%{$search}%")
                        ->orWhere('category', 'like', "%{$search}%")
                        ->orWhere('sub_category', 'like', "%{$search}%");
            });
        }

        $books = $booksQuery->get();

        $all_books = [];
        foreach ($books as $book) {
            $cover_obj = $book->cover()->first();
            $all_books[] = [
                'image' => ($cover_obj) ? asset('storage/' . $cover_obj->path) : asset('images/insight_1.png'),
                'id' => $book->id,
                'title' => $book->title,
                'subtitle' => $book->short_description,
                'time' => $book->read_time,
            ];
        }

        return view('books', ['all_books' => $all_books, 'search_text' => $search]);
    }
    public function readBook($slug){
        $user = Auth::user();
        $subscription = $user->subscription('default');
        if (! $subscription || ! $subscription->active()) {
            return redirect()->route('checkout')->with('warning', 'Devi abbonarti per accedere ai contenuti.');
        }

        return view('book-read', ['slug' => $slug]);
    }
    public function detailBook($slug){
        $book = Book::where('id', $slug)
            ->where('status', '1')
            ->first();
        $chapters = [];
        if (!$book) {
            return;
        }
        if ($book->chapters()) {
            $chapters = $book->chapters()->get();
        }
        $chapter_titles = [];
        $shorts = [];
        $short_count = 0;
        foreach ($chapters as $chapter) {
            $chapter_titles[] = ['title' => $chapter->title, 'content' => $chapter->title];
            if ($chapter['short']) {
                $shorts[] = ['text' => str_replace('\"', '"', $chapter['short']), 'total_count' => count($chapters), 'current' => $short_count];
            }
            $short_count ++;
        }
        /* Ultimi libri */
        $last_books_query = Book::where('status', 1)
            ->orderBy('created_at', 'desc') // Ordina dalla più recente alla più vecchia
            ->take(10) // Prendi solo gli ultimi 10
            ->get();
        $last_book = Book::where('status', 1)->latest()->first();
        $last_books = [];
        foreach ($last_books_query as $last_book) {
            $cover_obj = $last_book->cover()->first();
            $last_books[] = [
                'image' => ($cover_obj) ?  asset('storage/' . $cover_obj->path) : asset('images/insight_1.png'),
                'id' => $last_book->id,
                'title' => $last_book->title,
                'subtitle' => $last_book->short_description,
                'time' => $last_book->read_time,
            ];
        }
        
        return view('book-detail', ['slug' => $slug, 'book' => $book, 'chapters' => $chapter_titles, 'shorts' => $shorts, 'last_books' => $last_books]);
    }
}
