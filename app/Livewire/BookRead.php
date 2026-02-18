<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Book;
use App\Models\Highlight;
use App\Models\ReadingStatus;
use App\Models\QuestionAnswer;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Auth;


class BookRead extends Component
{
    public $book_id, $chapter_id, $title, $author, $chapter_name, $chapter_audio_path, $chapter_text, $chapter_long_text, $chapter_total_count, $chapter_relevant_quote, $open_questions_and_answers, $questions_and_answers, $highlights;
    public $chapter_number = 1;
    public $chapters;
    public $chapters_list;
    public $showLongSummaryFlag = false;
    public $showCertificationFlag = false;
    /*  */
    public $userAnswers = [];        // Risposte dell’utente (es. [0 => 1, 1 => 0])
    public $resultMessage = null;
    public $score = 0;
    /*  */
    protected $listeners = ['saveHighlight', 'deleteHighlight', 'saveHighlightNote'];
    public function render()
    {
        $this->dispatch('load-highlights', ($this->highlights) ? $this->highlights->toArray() : []);
        return view('livewire.book-read', [
            'highlights' => $this->highlights,
        ]);
    }
    public function mount(){
        $book = Book::where('id', $this->book_id)
                    ->where('status', '1')
                    ->first();
        //$this->chapter_number = Request::query('chapter', 1);

        if ($book) {
            $this->title = $book->title;
            $this->author = $book->author;
            $this->chapters = $book->chapters()->get();
            $this->chapter_total_count = $book->chapters()->count();

            $count = 1;
            foreach ($this->chapters as $chapter) {
                $this->chapters_list[$count] = $chapter->title;
                $count++;
            }
            $chapterNumber = Request::query('chapter');
            if (!$chapterNumber) {
                $readingStatus = ReadingStatus::where('user_id', auth()->id())
                                            ->where('book_id', $this->book_id)
                                            ->first();
                $chapterNumber = 1;
                $count = 1;
                if($readingStatus){
                    foreach ($this->chapters as $chapter) {
                        if ($chapter->id == $readingStatus->chapter_id) {
                            $chapterNumber = $count;
                        }
                        $count++;
                    }
                }
            }
            $this->chapter_number = $chapterNumber;
            
            $this->showChapter($this->chapter_number);
        }
    }
    public function showChapter($chapter_number = 1){
        $this->showCertificationFlag = false;
        $this->showLongSummaryFlag = false;

        $this->chapter_number = $chapter_number;
        $count = 1;
        foreach ($this->chapters as $chapter) {
            if ($this->chapter_number == $count) {
                $this->chapter_id = $chapter->id;
                $this->chapter_name = $chapter->title;
                $this->chapter_long_text = str_replace('\"', '"', $chapter->long_summary);
                $this->chapter_text = str_replace('\"', '"', $chapter->short_summary);
                $this->chapter_relevant_quote = $chapter->relevant_quote;
                $this->chapter_audio_path = $chapter->audio_path;
                /*  */
                $this->highlights = Highlight::where('user_id', auth()->id())
                                 ->where('chapter_id', $this->chapter_id)
                                 ->where('book_id', $this->book_id)
                                 ->get();
                /*  */
                $this->saveReadingStatus();
                /*  */
                $this->open_questions_and_answers = [];
                if ($chapter->open_questions_and_answers) {
                    $json = json_decode($chapter->open_questions_and_answers, true); // decodifica come array associativo
                
                    $result = [];
                
                    // Raggruppiamo per id_coppia
                    $grouped = [];
                    foreach ($json['elementi_testuali'] as $item) {
                        $grouped[$item['id_coppia']][$item['tipo']] = $item['contenuto'];
                    }
                
                    // Creiamo l'array finale
                    foreach ($grouped as $coppia) {
                        if (isset($coppia['domanda']) && isset($coppia['risposta'])) {
                            $result[] = [
                                'title'   => $coppia['domanda'],
                                'content' => $coppia['risposta']
                            ];
                        }
                    }
                
                    $this->open_questions_and_answers = $result;
                }
                /*  */
                $this->questions_and_answers = json_decode($chapter->questions_and_answers);

                /*  */
                $existing = QuestionAnswer::where('user_id', auth()->id())
                    ->where('book_id', $this->book_id)
                    ->where('chapter_id', $this->chapter_id)
                    ->first();

                    if ($existing) {
                        // Decodifica l'array salvato e convertilo in stringhe
                        $this->userAnswers = array_map('strval', json_decode($existing->answers, true) ?? []);
                        $this->score = $existing->score;
                    }

                //dd($this->userAnswers);
                /*  */
            }
            $count++;
        }

        $this->dispatch('scrollToTop');
    }
    public function previousChapter(){
        $this->chapter_number --;
        $this->showChapter($this->chapter_number);
    }
    public function nextChapter(){
        $this->chapter_number ++;
        $this->showChapter($this->chapter_number);
    }
    public function showLongSummary(){
        $this->showLongSummaryFlag = !$this->showLongSummaryFlag;
        $this->showCertificationFlag = false;
    }
    public function showCertification(){
        $this->showLongSummaryFlag = false;
        $this->showCertificationFlag = !$this->showCertificationFlag;
    }
    public function saveHighlight($text, $position){
        if (!$text || !$position || !$this->chapter_id)
            return;
        logger('saveHighlight-> '.$text);
        logger('saveHighlight-> '.json_encode($position));

        $highlight = Highlight::create([
            'user_id' => auth()->id(),
            'book_id' => $this->book_id,
            'chapter_id' => $this->chapter_id,
            'text' => $text,
            'position' => $position ? json_encode($position) : null,
        ]);
        $this->skipRender();
        $this->dispatch('highlight-saved', ['id' => $highlight->id]);
    }
    public function deleteHighlight($id){
        logger('deleteHighlight->'.$id);
        $highlight = Highlight::where('id', $id)
                          ->where('user_id', Auth::id())
                          ->first();
        if ($highlight && $highlight->user_id === auth()->id()) {
            $highlight->delete();
        }
    
        // Evita di ricaricare tutto il DOM se vuoi mantenere gli altri highlight
        $this->skipRender();
    }
    public function saveHighlightNote($id, $text){
        $highlight = Highlight::where('id', $id)
                          ->where('user_id', Auth::id())
                          ->first();

        if ($highlight) {
            $highlight->note = $text;
            $highlight->save();

            $this->highlights = Highlight::where('user_id', auth()->id())
                                 ->where('chapter_id', $this->chapter_id)
                                 ->where('book_id', $this->book_id)
                                 ->get();
            $this->dispatch('load-highlights', ($this->highlights) ? $this->highlights->toArray() : []);
            session()->flash('message', 'Nota salvata con successo!');
        } else {
            session()->flash('error', 'Highlight non trovato o non autorizzato.');
        }
    }
    public function checkQuestionResponse()
    {
        $score = 0;

        foreach ($this->questions_and_answers->domande as $qIndex => $domanda) {
            if (!isset($this->userAnswers[$qIndex])) {
                continue;
            }

            $selected = $this->userAnswers[$qIndex];
            $risposta = $domanda->risposte[$selected] ?? null;

            if ($risposta && $risposta->corretta) {
                $score++;
            }
        }

        $this->score = $score;
        $total = count($this->questions_and_answers->domande);

        if ($score === $total) {
            $this->resultMessage = "🎉 Complimenti! Tutte le risposte sono corrette!";
        } else {
            $this->resultMessage = "Hai risposto correttamente a $score su $total domande.";
        }

        QuestionAnswer::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'book_id' => $this->book_id,
                'chapter_id' => $this->chapter_id, 
            ],
            [
                'answers' => json_encode($this->userAnswers),  
            ]
        );
    }
    private function saveReadingStatus()
    {
        $percentage = 0;
        if ($this->chapter_total_count > 0) {
            $percentage = round(($this->chapter_number / $this->chapter_total_count) * 100, 2);
        }

        ReadingStatus::updateOrCreate(
            [
                'user_id'  => auth()->id(),
                'book_id'  => $this->book_id,
            ],
            [
                'chapter_id'        => $this->chapter_id,
                'status_percentage' => $percentage,
            ]
        );
    }
}
