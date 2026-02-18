<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    //
    protected $fillable = [
        'title',
        'long_summary',
        'short_summary',
        'short',
        'relevant_quote',
        'audio_path',
        'questions_and_answers',
        'open_questions_and_answers',
        'email_object',
        'email_body'
    ];
    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
