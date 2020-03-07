<?php

namespace App\Http\Controllers\Seller;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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
    protected $redirectTo;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('guest:admin')->except('logout');
        $this->middleware('guest:admin', ['except' => ['logout']]);
    }


    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();
        $redirectUrl = "/admin/dashboard";

        // checking users type here in loop
        foreach (Auth::guard('admin')->user()->role as $roles) {
            if ($roles->name == 'Superadmin') {
                $this->redirectTo = $redirectUrl;
                return redirect($redirectUrl);
            } elseif ($roles->name == 'Admin') {
                $this->redirectTo = $redirectUrl;
                return redirect($redirectUrl);
            } elseif ($roles->name == 'Editor') {
                $this->redirectTo = $redirectUrl;
                return redirect($redirectUrl);
            } elseif ($roles->name == 'Moderator') {
                $this->redirectTo = $redirectUrl;
                return redirect($redirectUrl);
            }
        }
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('myadmin.auth.login');
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('admin');
    }

    // function copied from Illuminate\Foundation\Auth\AuthenticatesUsers to logout admin guard
    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect('/admin');
    }
}