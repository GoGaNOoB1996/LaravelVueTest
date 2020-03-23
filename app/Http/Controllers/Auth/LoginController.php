<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Services\Oauth\GoogleOauth;
use App\Services\Oauth\WordpressOauth;
use App\Services\Oauth\FacebookOauth;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use App\User;
use Laravel\Spark\Events\Auth\UserRegistered;

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


    public function Oauth($service) {
        switch($service){
            case 'google': $uri = GoogleOauth::generateOauthUri();break;
            case 'wordpress': $uri = WordpressOauth::generateOauthUri();break;
            case 'facebook': $uri = FacebookOauth::generateOauthUri();break;
            default: return false;
        }
        return Redirect::to($uri);
    }


    public function OauthCallback(Request $request, $service) {
        if($request->get('error')){
            return false;
        } else {
            switch($service){
                case 'google':
                    $token = GoogleOauth::getAuthToken($request->get('code'));
                    $service_user = GoogleOauth:: getUser($token);
                    $user = User::where('email', $service_user->email)->first();
                    break;
                case 'wordpress':
                    $token = WordpressOauth::getAuthToken($request->get('code'));
                    $service_user = WordpressOauth:: getUser($token);
                    $user = User::where('email', $service_user->email)->first();
                    break;
                case 'facebook':
                    $token = FacebookOauth::getAuthToken($request->get('code'));
                    $service_user = FacebookOauth:: getUser($token);
                    break;
                default: return false;
            }
            if(!empty($user)){
                auth()->login($user);
                return redirect()->to($this->redirectTo);
            } else {
                $user = User::create([
                    'name' => isset($service_user->name) ? $service_user->name : $service_user->display_name,
                    'email' => $service_user->email,
                    'password' => Hash::make(Str::random(8))
                ]);
                $user->markEmailAsVerified();
                event(new Verified($user));
                auth()->login($user);
                return redirect()->to($this->redirectTo);
            }
        }
    }
}
