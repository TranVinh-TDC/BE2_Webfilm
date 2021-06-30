<?php

namespace App\Http\Controllers;

use App\Http\Requests\FilmRequest;
use App\Http\Requests\UpdateFilmRequest;
use App\Models\Category;
use App\Models\Film;
use App\Models\Nation;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FilmController extends Controller
{
    public function __construct()
    {
        $this->middleware('count')->only(['index', 'create']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('films.index')
            ->with('films', Film::orderBy('created_at', 'desc')->simplePaginate(6))
            ->with('types', Type::all())
            ->with('categories', Category::all());
    }


    public function create()
    {
        return view('films.form')
            ->with('categories', Category::all())
            ->with('types', Type::all())
            ->with('nations', Nation::all());
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FilmRequest $request)
    {
        //dd($request->published);
        //upload the image to storage.
        $image = $request->image->store('images/films');

        //insert db
        $film = Film::create([
            'name' => $request->name,
            'image' => $image,
            'content' => $request->content,
            'description' => $request->description,
            'imdb' => $request->imdb,
            'original_name' => $request->original_name,
            'published' => $request->published,
            'status' => $request->status,
            'director' => $request->director,
            'actor' => $request->actor,
            'type_id' => $request->type_id,
            'nation_id' => $request->nation_id,
            'views' => $request->views,
        ]);
        //
        if ($request->categories) {
            $film->categories()->attach($request->categories);
        }
        session()->flash('success', "Film created successfully");

        return redirect(route('films.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Film $film)
    {
        return view('films.form')
            ->with('film', $film)
            ->with('categories', Category::all())
            ->with('types', Type::all())
            ->with('nations', Nation::all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFilmRequest $request, Film $film)
    {
        $data = $request->only(['name', 'content', 'description', 'imdb', 'published_at']);
        // store image new, and delete image old
        if ($request->hasFile('image')) {
            //image new
            $image = $request->image->store('images/films');

            $film->deleteImage();

            //cap nhat image moi
            $data['image'] = $image;
        }
        //
        $film->update($data);

        if ($request->categories) {
            $film->categories()->sync($request->categories);
        }

        session()->flash('success', "Film edit successfully");

        return redirect(route('films.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $film  = Film::withTrashed()->where('id', '=', $id)->firstOrFail();
        if (!$film->trashed()) {
            //trash
            $film->delete();
            session()->flash('success', "Film trash successfully");
        } else {
            if ($film->link()) {
                //remove image
                $film->deleteImage();
                //remove db.
                $film->forceDelete();

                session()->flash('success', "Film deleted successfully");
            } else {
                session()->flash('error', "film cannot be deleted, because it is associate to some link");
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function trash_film()
    {
        //dd(Film::onlyTrashed());
        return view('films.index')
            ->with('films', Film::onlyTrashed()->orderBy('created_at', 'desc')->simplePaginate(6))
            ->with('categories', Category::all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $film  = Film::onlyTrashed()->where('id', '=', $id)->firstOrFail();

        $film->restore();
        session()->flash('success', "Film restore successfully");
        return redirect()->back();
    }

    function searchFilm()
    {
        return 'this is search film';
    }
}
