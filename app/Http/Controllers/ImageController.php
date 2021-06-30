<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImageRequest;
use App\Http\Requests\UpdateImageRequest;
use App\Models\Film;
use App\Models\Image;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $images = Image::join('films', 'films.id', '=', 'images.film_id')
            ->select('images.*')
            ->orderBy('films.imdb', 'desc')
            ->orderBy('films.views', 'desc')
            ->simplePaginate(5);
        
        return view('images.index')
            ->with('images', $images)
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
        return view('images.form')
            ->with('films', Film::all());
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ImageRequest $request)
    {
        //dd($request);
        $image = $request->image->store('images/relations');
        //

        $image = Image::create([
            'film_id' => $request->film_id,
            'image' => $image,
        ]);

        //
        //dd($request->film);
        session()->flash('success', "Image created successfully");

        return redirect(route('images.index'));
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
    public function edit(Image $image)
    {
        //tra lai du lieu cho ajax.
        return view('images.form')
            ->with('image', $image)
            ->with('films', Film::all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateImageRequest $request, Image $image)
    {
        $data = $request->only(['film_id']);
        //
        if ($request->hasFile('fimage')) {
            //storage new Image
            $image = $request->fimage->store('images/relations');
            //delete old Image
            $image->deleteImage();
            //gan Image cho data.
            $data['images'] = $image;
        }
        //update
        $image->update($data);
        //dd($request->film);

        session()->flash('success', "Image edits successfully");
        return redirect(route('images.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Image $image)
    {
        //delete Image
        $image->delete();

        session()->flash('success', "Image deleted successfully");
    }
}
