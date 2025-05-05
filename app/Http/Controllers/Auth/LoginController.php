<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home'; // Default redirect path

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'login'; // We will use 'login' as the input name for both email and resident number
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        // Validate the request
        $this->validate($request, [
            'login' => 'required|string',
            'password' => 'required|string',
        ]);

        // Determine if the input is an email or resident number
        $field = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'resident_number';

        // Attempt to log the user in
        if (Auth::attempt([$field => $request->login, 'password' => $request->password])) {
            // Authentication passed...
            return $this->authenticated($request, Auth::user());
        }

        // If authentication fails, redirect back with an error
        return back()->withErrors([
            'login' => 'The provided credentials do not match our records.',
        ])->withInput($request->only('login'));
    }

    /**
     * Handle the authenticated user.
     *
     * @return \Illuminate\Http\Response
     */
    protected function authenticated(Request $request, $user)
    {
        if ($user->role_as == '1') {
            return redirect('/admin/dashboard')->with('status', 'Welcome to Admin Dashboard');
        } elseif ($user->role_as == '2') {
            return redirect()->route('monitor.dashboard')->with('status', 'Welcome to Monitor Dashboard');
        } else {
            return redirect('/')->with('status', 'Logged In Successfully');
        }
    }
}
