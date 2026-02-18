<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuestionAnswer extends Model
{
    protected $fillable = [
        'user_id',
        'book_id',
        'chapter_id',
        'answers',
    ];

    protected $casts = [
        'answers' => 'array',
    ];
}
