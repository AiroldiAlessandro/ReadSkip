<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReadingStatus extends Model
{

    use HasFactory;
    protected $fillable = [
        'user_id',
        'book_id',
        'chapter_id',
        'status_percentage',
    ];
    public function user() {
        return $this->belongsTo(User::class);
    }
    public function chapter() {
        return $this->belongsTo(Chapter::class);
    }
    public function book() {
        return $this->belongsTo(Book::class);
    }
}
