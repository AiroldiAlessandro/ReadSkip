<?php

use Illuminate\Support\Facades\Route;

/*  */
use App\Models\Book;
use App\Models\Chapter;
use App\Models\ReadingStatus;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookController;
/*  */

Route::get('/', [BookController::class, 'loadHome'])->name('home');
Route::get('/books', [BookController::class, 'loadBooksList'])->name('books');
Route::get('/book/{slug}', [BookController::class, 'detailBook']);


Route::middleware(['auth'])->group(function () {
    /* Read Book */
    Route::get('/read/{slug}', [BookController::class, 'readBook']);
    /* Profile */
    Route::get('/mynote', [ProfileController::class, 'noteView'])->name('user.note');
    Route::get('/profile', [ProfileController::class, 'profileView'])->name('user.profile');
    /* Subscription */
    Route::get('/checkout', [ProfileController::class, 'checkout'])->name('checkout');
    Route::get('/checkout/success', function () {
        return redirect('/');
    })->name('checkout.success');
    Route::get('/checkout/cancel', function () {
        return redirect('/');
        //return "Pagamento annullato.";
    })->name('checkout.cancel');
    Route::post('/subscription/cancel', [ProfileController::class, 'cancelSubscription'])->name('subscription.cancel');
});
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/booklist', [AdminController::class, 'bookListView'])->name('admin.booklist');
    Route::get('/bookdetail/{id}', [AdminController::class, 'bookDetailView'])->name('admin.bookdetail');
    Route::post('/bookdetail/{id}', [AdminController::class, 'updateBook'])->name('admin.updatebook');
    Route::post('/booklist', [AdminController::class, 'bookListData'])->name('admin.booklist-data');
    Route::get('/chaptersdetail/{id}', [AdminController::class, 'chaptersDetailView'])->name('admin.chaptersdetail');
    Route::post('/chaptersdetail/{id}', [AdminController::class, 'updateChapters'])->name('admin.updatechapters');
    Route::get('/deletebook/{id}', [AdminController::class, 'deleteBook'])->name('admin.deletebook');
});
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified', ])->group(function () {
    Route::get('/dashboard', function () {
        $user = auth()->user();

        if ($user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        }

        if ($user->hasRole('customer')) {
            return redirect('/');
        }

        // fallback generico
        return redirect('/');
    })->name('dashboard');
});
Route::get('/test', function () {
    
});


