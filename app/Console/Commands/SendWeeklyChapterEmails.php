<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ReadingStatus;
use App\Models\SentChapterEmail;
use Illuminate\Support\Facades\Mail;

class SendWeeklyChapterEmails extends Command
{
    protected $signature = 'emails:send-weekly-chapters';
    protected $description = 'Invia capitoli settimanali per libri completati';

    public function handle()
    {
        $completed = ReadingStatus::where('status_percentage', 100)->get();

        foreach ($completed as $reading) {
            $user = $reading->user;
            $book = $reading->book;

            $chapters = $book->chapters()->orderBy('number')->get();

            $sentChapterIds = SentChapterEmail::where('user_id', $user->id)
                                ->pluck('chapter_id')->toArray();

            // cicla tra i capitoli finché non trovi uno da inviare
            foreach ($chapters as $chapter) {
                if (in_array($chapter->id, $sentChapterIds)) {
                    // è già stato inviato: salta
                    continue;
                }

                // controlla che oggetto e corpo non siano nulli o vuoti
                if (empty($chapter->email_object) || empty($chapter->email_body)) {
                    // salta questo capitolo e vai al prossimo
                    continue;
                }

                // se siamo qui: questo capitolo è il primo non inviato con oggetto e corpo validi
                Mail::send([], [], function ($message) use ($user, $chapter) {
                    $message->to($user->email)
                            ->subject($chapter->email_object)
                            ->html($chapter->email_body);
                });

                SentChapterEmail::create([
                    'user_id' => $user->id,
                    'chapter_id' => $chapter->id,
                    'sent_at' => now(),
                ]);

                $this->info("Inviata email a {$user->email} per capitolo {$chapter->id}");
                
                // esci dal loop interno: una sola email per utente per esecuzione settimanale
                break;
            }
        }

        $this->info("Comando completato.");
    }
}
