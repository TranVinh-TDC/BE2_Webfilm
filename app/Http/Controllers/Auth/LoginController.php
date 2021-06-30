<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Auth\User;
use Laravel\Socialite\Facades\Socialite;
use Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

        //Google Socialite
        public function redirecToGoogle()
        {
            return Socialite::driver('google')->redirect();
        }
    
        public function handleGoogleCallback()
        {
            $user = Socialite::driver('google')->stateless()->user();
            $this->_registerOrLoginUser($user);
            //return home after login
            return redirect()->route('home');
        }
    
        //FaceBook Socialite
        public function redirecTofacebook()
        {
            return Socialite::driver('facebook')->redirect();   
        }
    
        public function handleFacebookCallback()
        {
            $user = Socialite::driver('facebook')->user();
    
            $this->_registerOrLoginUser($user);
    
            //return home after login
            return redirect()->route('home');
        }
    
        protected function _registerOrLoginUser($data)
        {
            $user = User::where('email', '=', $data->email)->first();
            if (!$user) {
                $user = new User();
    
                $user->name  = $data->name;
                $user->email  = $data->email;
                $user->provider_id  = $data->id;
                $user->avatar  = $data->avatar;
    
                $user->save();
            }
            Auth::login($user);
        }
}
