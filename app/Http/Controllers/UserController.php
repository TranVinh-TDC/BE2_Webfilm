<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileUser;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    public function index()
    {
        return view('users.index')
            ->with('users', User::orderBy('created_at', 'desc')->simplePaginate(6));
    }

    public function makeAdmin($id)
    {
        $user =  User::where('id', '=', $id)->first();
        // dd($user);
        $user->role = 'admin';

        $user->save();
        session()->flash('success', "this user became admin");
        return redirect(route('users.index'));   
    }

    public function edit()
    {
        return view('users.edit-profile')->with('user', auth()->user());
    }

    public function update(UpdateProfileUser $request)
    {
        $user = auth()->user();

        $user->update([
            'name'=>$request->name,
            'about'=>$request->about,
        ]);

        return redirect(route('users.index'));
    }
}
