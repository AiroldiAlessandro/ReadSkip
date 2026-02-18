<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    //
    protected $fillable = [
        'title',
        'author',
        'read_time',
        'status',
        'category',
        'sub_category',
        'short_description',
        'long_description'
    ];
    public function chapters()
    {
        return $this->hasMany(Chapter::class);
    }
    public function cover()
    {
        return $this->hasOne(Cover::class);
    }
    // Relazione con ReadingStatus
    public function readingStatuses()
    {
        return $this->hasMany(ReadingStatus::class);
    }
}
