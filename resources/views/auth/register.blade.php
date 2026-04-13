@extends('layouts.app')
@section('title', 'Inscription')

@section('content')
<div class="max-w-md mx-auto bg-white p-8 rounded shadow">
    <h1 class="text-2xl font-bold mb-6 text-center text-green-600">Créer un compte</h1>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-medium mb-1">Nom complet</label>
            <input type="text" name="nom" value="{{ old('nom') }}"
                class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-400">
            @error('nom') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email') }}"
                class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-400">
            @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Université</label>
            <input type="text" name="university" value="{{ old('university') }}"
                class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-400">
            @error('university') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="block text-sm font-medium mb-2">Centres d'intérêt</label>
            <div class="flex gap-4 flex-wrap">
                @foreach(['Social', 'Animaux', 'Écologie'] as $interest)
                    <label class="flex items-center gap-2 text-sm">
                        <input type="checkbox" name="interests[]" value="{{ $interest }}"
                            {{ in_array($interest, old('interests', [])) ? 'checked' : '' }}>
                        {{ $interest }}
                    </label>
                @endforeach
            </div>
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Mot de passe</label>
            <input type="password" name="password"
                class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-400">
            @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Confirmer le mot de passe</label>
            <input type="password" name="password_confirmation"
                class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-400">
        </div>
        <button class="w-full bg-green-600 text-white py-2 rounded hover:bg-green-700">S'inscrire</button>
    </form>

    <p class="text-center text-sm mt-4">Déjà un compte ?
        <a href="{{ route('login') }}" class="text-green-600 hover:underline">Se connecter</a>
    </p>
</div>
@endsection
