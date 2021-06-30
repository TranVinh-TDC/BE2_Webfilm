<?php

namespace App\Http\Controllers;

use App\Http\Requests\NationRequest;
use App\Http\Requests\UpdateNationRequest;
use App\Models\Nation;
use Illuminate\Http\Request;

class NationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $nations = Nation::withCount('films')
        ->orderBy('films_count', 'desc')
        ->simplePaginate(6);

        return view('nations.index')
            ->with('nations', $nations);
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
    public function store(NationRequest $request)
    {
        //
        $nation = new Nation;
        $nation->create([
            'name' => $request->name,
        ]);

        session()->flash('success', "nation created successfully");
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
    public function edit(Nation $nation)
    {
        //tra lai du lieu cho ajax.
        return response()->json($nation);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateNationRequest $request, Nation $nation)
    {
        //
        $nation->update([
            'name' => $request->name,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Nation $nation)
    {
        //
        if (!$nation->films() && $nation->films->count() > 0) {
            session()->flash('error', 'nation cannot be deleted, because it is associate to some flims');
        } else {
            $nation->delete();
            session()->flash('success', "nation deleted successfully");
        }
    }
}
