<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Highlight;
use App\Models\Book;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    private $user;
    function __construct(){
        $this->user =  Auth::user();
    }
    public function noteView(){
        $highlights = $this->user->highlights()->get();
        $user_highlights = $this->user->highlights()->get();
        $highlights = [];
        foreach ($user_highlights as $highlight) {
            $chapter = $highlight->chapter()->first();
            $book = $chapter->book()->first();
            $chapters = $book->chapters()->get();
            $count = 1;
            $chapter_count = 0;
            $chapter_name = 'uno';
            foreach ($chapters as $single_chapter) {
                if ($single_chapter->id == $highlight->chapter_id) {
                    $chapter_count = $count;
                    $chapter_name = $single_chapter->title;
                    break;
                }
                $count ++;
            }
            $data = [];
            $data['text'] = $highlight->text;
            $data['book_id'] = $highlight->book_id;
            $data['chapter'] = $chapter_count;
            $data['chapter_title'] = $chapter_name;
            $data['book_title'] = $book->title;
            $highlights[$highlight->id] = $data;
        }
        return view('customer-profile.my-note', compact('highlights'));
    }
    public function profileView(){
        return view('customer-profile.profile');
    }
    public function checkout(){
        $user = auth()->user();

        // Sostituisci 'price_xxx' con l'ID del tuo piano Stripe
        $checkoutSession = $user->checkout(env('STRIPE_PRODUCT'), [
            'success_url' => route('checkout.success'),
            'cancel_url' => route('checkout.cancel'),
            'mode' => 'subscription',
            'allow_promotion_codes' => true,
        ]);

        // Redirect diretto al checkout di Stripe
        return redirect($checkoutSession->url);
    }
    public function cancelSubscription(){
        $user = auth()->user();
        $subscription = $user->subscription('default');

        if ($subscription && $subscription->active()) {
            $subscription->cancel(); // Cancella al termine del periodo pagato
        }

        return redirect()->back()->with('success', 'Abbonamento cancellato. Resterai attivo fino alla fine del periodo.');
    }
}
