<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Support\Facades\Auth;
use App\Models\Activity;
class LoginController extends Controller
{

    use AuthenticatesUsers;


    protected $redirectTo = RouteServiceProvider::HOME;


    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

         $this->clearLoginAttempts($request);

         if ($response = $this->authenticated($request, $this->guard()->user())) {
             return $response;
      }

        Activity::create([
            'activity' => 'User logged in',
            'user_id' => Auth::user()->id
        ]);



        $redirectTo = '/admin/dashboard';


         return $request->wantsJson()
                     ? new JsonResponse([], 204)
                     : redirect($redirectTo);
     }

     public function logout(Request $request)
    {

        Activity::create([
            'activity' => 'User logged out',
            'user_id' => Auth::user()->id
        ]);


        $this->guard()->logout();

        $request->session()->invalidate();

        return $this->loggedOut($request) ?: redirect('/login');
    }
}
