<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use App\Models\Category;

class Film extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $fillable = [
        'name', 'original_name', 'image',
        'status', 'imdb', 'description',
        'director', 'actor', 'type_id',
        'nation_id', 'published', 'views'
    ];


    public function deleteImage()
    {
        //Delete image
        Storage::delete($this->image);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'films_categories');
    }

    public function link()
    {
        return $this->hasOne(LinkTrailer::class, 'film_id');
    }

    public function images()
    {
        return $this->hasMany(Image::class, 'film_id');
    }

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public function nation()
    {
        return $this->belongsTo(Nation::class);
    }

    public function hasType($id)
    {
        return $this->type->id == $id;
    }

    public function hasNation($id)
    {
        return $this->nation->id == $id;
    }

    public function hasCategories($id)
    {
        return  in_array($id, $this->categories->pluck('id')->toArray());
    }

    public function formatPublished()
    {
        return date("F, d Y", strtotime($this->published));
    }

    public function casts()
    {
        return $this->belongsToMany(Cast::class, 'cast_film');
    }

    public function hasCasts($id)
    {
        return  in_array($id, $this->casts->pluck('id')->toArray());
    }
}
