@extends('layouts.app')
@section('title', 'Connexion')

@section('content')
<div class="max-w-md mx-auto bg-white p-8 rounded shadow">
    <h1 class="text-2xl font-bold mb-6 text-center text-green-600">Connexion</h1>

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-medium mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email') }}"
                class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-400">
            @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Mot de passe</label>
            <input type="password" name="password"
                class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-400">
        </div>
        <button class="w-full bg-green-600 text-white py-2 rounded hover:bg-green-700">Se connecter</button>
    </form>

    <p class="text-center text-sm mt-4">Pas encore de compte ?
        <a href="{{ route('register') }}" class="text-green-600 hover:underline">S'inscrire</a>
    </p>
</div>
@endsection
