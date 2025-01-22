<?php

namespace App\Http\Controllers\Auth\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $checkDetails = Auth::attempt($credentials);

        if ($checkDetails) {
            return redirect()->route('user.dashboard');
        }

        $user = Auth::user();

        if ($user->is_banned) {
            return redirect()->back()->with('error', 'Your account has been banned | Reason: ' . $user->ban_reason);
        }

        return redirect()->back()->with('error', 'Invalid login details');
    }

    public function loginPage()
    {
        return Inertia::render('Auth/Login');
    }

    public function register(Request $request)
    {

    }
}
