<?php

namespace App\Http\Controllers;

use App\Http\Requests\CastRequest;
use App\Http\Requests\UpdateCastRequest;
use App\Models\Cast;
use App\Models\Film;
use Illuminate\Http\Request;

class CastController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $casts =  Cast::withCount('films')
            ->orderBy('films_count', 'desc')
            ->simplePaginate(6);
        return view('casts.index')
            ->with('casts', $casts)
            ->with('films', Film::all());
    }


    /**
     * Create a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('casts.form')
            ->with('films', Film::all());
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CastRequest $request)
    {
        $image = $request->image->store('images/casts');
        //
        $cast = Cast::create([
            'name' => $request->name,
            'image' => $image,
        ]);

        //
        //dd($request->film);
        if ($request->film) {
            $cast->films()->attach($request->film);
        }
        session()->flash('success', "casts created successfully");

        return redirect(route('casts.index'));
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
    public function edit(Cast $cast)
    {
        //tra lai du lieu cho ajax.
        return view('casts.form')
            ->with('cast', $cast)
            ->with('films', Film::all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCastRequest $request, Cast $cast)
    {
        $data = $request->only(['name']);
        //
        if ($request->hasFile('image')) {
            //storage new image
            $image = $request->image->store('images/casts');
            //delete old image
            $cast->deleteImage();
            //gan image cho data.
            $data['image'] = $image;
        }
        //update
        $cast->update($data);
        //dd($request->film);
        if ($request->film) {
            $cast->films()->sync($request->film);
        }

        session()->flash('success', "Cast edits successfully");
        return redirect(route('casts.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cast $cast)
    {
        // delete the relationships with Tags (Pivot table) first.
        $cast->find($cast->id)->films()->detach();
        //delete cast
        $cast->delete();

        session()->flash('success', "Cast deleted successfully");
    }
}
