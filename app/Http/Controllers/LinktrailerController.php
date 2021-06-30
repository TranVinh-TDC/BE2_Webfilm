<?php

namespace App\Http\Controllers;

use App\Http\Requests\LinktrailerRequest;
use App\Http\Requests\UpdateLinktrailerRequest;
use App\Models\Film;
use App\Models\Linktrailer;
use Illuminate\Http\Request;

class LinktrailerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('links.index')
            ->with('links', Linktrailer::orderBy('created_at', 'desc')
                ->simplePaginate(5))
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
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LinktrailerRequest $request)
    {
        //
        $linktrailer = new Linktrailer;
        $linktrailer->create([
            'name' => $request->name,
            'film_id' => $request->film_id,
        ]);

        session()->flash('success', "linktrailer created successfully");
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
    public function edit($id)
    {
        $linktrailer = Linktrailer::find($id);
        //tra lai du lieu cho ajax.
        return response()->json($linktrailer);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLinktrailerRequest $request, $id)
    {
        $linktrailer = Linktrailer::find($id);
        //
        $linktrailer->update([
            'name' => $request->name,
            'film_id' => $request->film_id,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Linktrailer $linktrailer)
    {
        //
        if ($linktrailer->films) {
            session()->flash('error', 'linktrailer cannot be deleted, because it is associate to some flims');
        } else {
            $linktrailer->delete();
            session()->flash('success', "linktrailer deleted successfully");
        }
    }
}
