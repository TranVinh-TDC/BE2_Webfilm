<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Film;
use App\Models\Nation;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $film = Film::orderBy('views', 'desc')
            ->orderBy('imdb', 'desc')
            ->get();
        
        $playing = Film::withCount('link')
            ->having('link_count', '>', 0)
            ->orderBy('views', 'desc')->get();
        
            return view('movies.index')
            ->with('films', collect($film)->take(20))
            ->with('playing', collect($playing)->take(20))
            ->with('categories',  Category::all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $movie = Film::find($id);
        //
        return view('movies.show')
            ->with('movie', $movie)
            ->with('films', Film::all())
            ->with('types', Type::all())
            ->with('categories', Category::all());
    }
}
