<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LinkTrailer extends Model
{
    use HasFactory;
    
    protected $fillable = ['name','film_id'];

    public function films()
    {
        return $this->belongsTo(Film::class, 'film_id');
    }
}
