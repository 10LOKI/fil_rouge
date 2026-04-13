@extends('layouts.app')
@section('title', $event->title)

@section('content')
<div class="max-w-2xl mx-auto bg-white rounded shadow p-8">
    <div class="flex items-center gap-3 mb-2">
        <span class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded">{{ $event->category }}</span>
        <span class="text-xs text-gray-400">{{ $event->date_event->format('d M Y à H:i') }}</span>
    </div>

    <h1 class="text-2xl font-bold mb-2">{{ $event->title }}</h1>
    <p class="text-sm text-gray-500 mb-6">Organisé par <strong>{{ $event->partner->company_name }}</strong></p>

    <div class="flex items-center gap-6 mb-8 p-4 bg-green-50 rounded">
        <div class="text-center">
            <p class="text-2xl font-bold text-green-600">+{{ $event->points_worth }}</p>
            <p class="text-xs text-gray-500">points</p>
        </div>
        <div class="text-center">
            <p class="text-sm font-semibold capitalize">{{ $event->status }}</p>
            <p class="text-xs text-gray-500">statut</p>
        </div>
    </div>

    @auth
        @if(Auth::user()->hasRole('student'))
            @if($alreadyJoined)
                <p class="text-green-600 font-medium">✓ Vous êtes inscrit à cet événement.</p>
            @else
                <form method="POST" action="{{ route('events.join', $event) }}">
                    @csrf
                    <button class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">
                        Participer
                    </button>
                </form>
            @endif
        @endif
    @else
        <a href="{{ route('register') }}" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700 inline-block">
            Inscrivez-vous pour participer
        </a>
    @endauth

    <div class="mt-6">
        <a href="{{ route('events.index') }}" class="text-sm text-gray-400 hover:underline">← Retour aux événements</a>
    </div>
</div>
@endsection
