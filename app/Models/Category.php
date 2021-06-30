<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Film;
class Category extends Model
{
    use HasFactory;
    
    protected $fillable = ['name',];

    public function films()
    {
        return $this->belongsToMany(Film::class, 'films_categories', '');
    }
}
