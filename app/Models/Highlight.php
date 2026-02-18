<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Highlight extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'book_id',
        'chapter_id',
        'text',
        'position',
        'note',
    ];

    // Relazioni
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function chapter() {
        return $this->belongsTo(Chapter::class);
    }
}