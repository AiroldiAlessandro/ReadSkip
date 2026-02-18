<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cover extends Model
{
    //
    protected $fillable = [
        'path',
    ];
    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
