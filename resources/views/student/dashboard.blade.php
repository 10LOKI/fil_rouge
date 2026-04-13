@extends('layouts.app')
@section('title', 'Mon Dashboard')

@section('content')
<h1 class="text-2xl font-bold mb-6">Bonjour, {{ Auth::user()->nom }} 👋</h1>

{{-- Stats --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
    <div class="bg-white rounded shadow p-5 text-center">
        <p class="text-3xl font-bold text-green-600">{{ $student->total_points }}</p>
        <p class="text-sm text-gray-500 mt-1">Points cumulés</p>
    </div>
    <div class="bg-white rounded shadow p-5 text-center">
        <p class="text-3xl font-bold text-blue-500">{{ $student->participations()->count() }}</p>
        <p class="text-sm text-gray-500 mt-1">Événements rejoints</p>
    </div>
    <div class="bg-white rounded shadow p-5 text-center">
        <p class="text-3xl font-bold text-purple-500">{{ $transactions->count() }}</p>
        <p class="text-sm text-gray-500 mt-1">Récompenses échangées</p>
    </div>
</div>

{{-- Événements à venir --}}
<div class="bg-white rounded shadow p-6 mb-6">
    <h2 class="font-semibold text-lg mb-4">Événements à venir</h2>
    @if($upcomingEvents->isEmpty())
        <p class="text-gray-400 text-sm">Aucun événement à venir.
            <a href="{{ route('events.index') }}" class="text-green-600 hover:underline">Rejoindre un événement</a>
        </p>
    @else
        <ul class="divide-y">
            @foreach($upcomingEvents as $p)
                <li class="py-3 flex items-center justify-between">
                    <div>
                        <p class="font-medium">{{ $p->event->title }}</p>
                        <p class="text-xs text-gray-400">{{ $p->event->date_event->format('d/m/Y') }} · {{ $p->event->category }}</p>
                    </div>
                    <span class="text-green-600 text-sm font-semibold">+{{ $p->event->points_worth }} pts</span>
                </li>
            @endforeach
        </ul>
    @endif
</div>

{{-- Historique transactions --}}
<div class="bg-white rounded shadow p-6">
    <h2 class="font-semibold text-lg mb-4">Historique des échanges</h2>
    @if($transactions->isEmpty())
        <p class="text-gray-400 text-sm">Aucun échange effectué.
            <a href="{{ route('rewards.index') }}" class="text-green-600 hover:underline">Voir les récompenses</a>
        </p>
    @else
        <ul class="divide-y">
            @foreach($transactions as $t)
                <li class="py-3 flex items-center justify-between">
                    <div>
                        <p class="font-medium">{{ $t->reward->label }}</p>
                        <p class="text-xs text-gray-400">{{ $t->redeemed_at->format('d/m/Y') }}</p>
                    </div>
                    <span class="font-mono text-sm bg-gray-100 px-2 py-1 rounded">{{ $t->unique_code }}</span>
                </li>
            @endforeach
        </ul>
    @endif
</div>
@endsection
