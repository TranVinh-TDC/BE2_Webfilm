<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Cast extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'image'];

    public function films()
    {
        return $this->belongsToMany(Film::class, 'cast_film');
    }

    public function deleteImage()
    {
        Storage::delete($this->image);
    }
}
