<?php

namespace App\Http\Controllers;

use App\Actions\Auth\RegisterStudentAction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request, RegisterStudentAction $action)
    {
        $data = $request->validate([
            'nom'        => 'required|string|max:255',
            'email'      => 'required|email|unique:users',
            'password'   => 'required|min:8|confirmed',
            'university' => 'required|string|max:255',
            'interests'  => 'nullable|array',
        ]);

        $user = $action->handle($data);

        Auth::login($user);

        return redirect()->route('events.index');
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($credentials)) {
            return back()->withErrors(['email' => 'Identifiants incorrects.']);
        }

        $request->session()->regenerate();

        return match (true) {
            Auth::user()->hasRole('admin')   => redirect()->route('admin.dashboard'),
            Auth::user()->hasRole('partner') => redirect()->route('partner.dashboard'),
            default                          => redirect()->route('events.index'),
        };
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
