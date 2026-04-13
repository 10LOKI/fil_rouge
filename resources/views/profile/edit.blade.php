@extends('layouts.app')
@section('title', 'Mon Profil')

@section('content')
<div class="max-w-lg mx-auto bg-white rounded shadow p-8">
    <h1 class="text-2xl font-bold mb-6">Mon Profil</h1>

    <form method="POST" action="{{ route('profile.update') }}" class="space-y-4">
        @csrf @method('PUT')

        <div>
            <label class="block text-sm font-medium mb-1">Nom complet</label>
            <input type="text" name="nom" value="{{ old('nom', $user->nom) }}"
                class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-400">
            @error('nom') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}"
                class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-400">
            @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        @if($user->role === 'student')
            <div>
                <label class="block text-sm font-medium mb-1">Université</label>
                <input type="text" name="university" value="{{ old('university', $user->student->university) }}"
                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-400">
            </div>
            <div>
                <label class="block text-sm font-medium mb-2">Centres d'intérêt</label>
                <div class="flex gap-4 flex-wrap">
                    @foreach(['Social', 'Animaux', 'Écologie'] as $interest)
                        <label class="flex items-center gap-2 text-sm">
                            <input type="checkbox" name="interests[]" value="{{ $interest }}"
                                {{ in_array($interest, old('interests', $user->student->interests ?? [])) ? 'checked' : '' }}>
                            {{ $interest }}
                        </label>
                    @endforeach
                </div>
            </div>
        @endif

        <hr>

        <div>
            <label class="block text-sm font-medium mb-1">Nouveau mot de passe <span class="text-gray-400">(laisser vide pour ne pas changer)</span></label>
            <input type="password" name="password"
                class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-400">
            @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Confirmer le mot de passe</label>
            <input type="password" name="password_confirmation"
                class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-400">
        </div>

        <button class="w-full bg-green-600 text-white py-2 rounded hover:bg-green-700">
            Enregistrer les modifications
        </button>
    </form>
</div>
@endsection
