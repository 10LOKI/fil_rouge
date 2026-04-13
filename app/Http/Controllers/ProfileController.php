<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('profile.edit', ['user' => Auth::user()]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'nom'      => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8|confirmed',
        ]);

        $user->update([
            'nom'   => $data['nom'],
            'email' => $data['email'],
            ...($data['password'] ? ['password' => Hash::make($data['password'])] : []),
        ]);

        if ($user->hasRole('student')) {
            $request->validate([
                'university' => 'required|string|max:255',
                'interests'  => 'nullable|array',
            ]);
            $user->student->update([
                'university' => $request->university,
                'interests'  => $request->interests ?? [],
            ]);
        }

        return back()->with('success', 'Profil mis à jour.');
    }
}
