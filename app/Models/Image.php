<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $fillable = ['image','film_id', ];

    public function film()
    {
        return $this->belongsTo(Film::class,'film_id');
    }

    public function hasFilm($id)
    {
        return $this->film->id==$id;
    }
}
