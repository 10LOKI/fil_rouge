@extends('layouts.app')
@section('title', 'Événements')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold">Événements de bénévolat</h1>
    <form method="GET" class="flex gap-2">
        <select name="category" class="border rounded px-3 py-2 text-sm">
            <option value="">Toutes les catégories</option>
            @foreach(['Social', 'Animaux', 'Écologie'] as $cat)
                <option value="{{ $cat }}" {{ request('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
            @endforeach
        </select>
        <button class="bg-green-600 text-white px-4 py-2 rounded text-sm hover:bg-green-700">Filtrer</button>
    </form>
</div>

@if($events->isEmpty())
    <p class="text-gray-500 text-center py-12">Aucun événement disponible pour le moment.</p>
@else
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($events as $event)
            <div class="bg-white rounded shadow p-5 flex flex-col gap-3">
                <div class="flex items-center justify-between">
                    <span class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded">{{ $event->category }}</span>
                    <span class="text-xs text-gray-400">{{ $event->date_event->format('d/m/Y') }}</span>
                </div>
                <h2 class="font-semibold text-lg">{{ $event->title }}</h2>
                <p class="text-sm text-gray-500">Par {{ $event->partner->company_name }}</p>
                <div class="flex items-center justify-between mt-auto">
                    <span class="text-green-600 font-bold text-sm">+{{ $event->points_worth }} pts</span>
                    <a href="{{ route('events.show', $event) }}"
                        class="bg-green-600 text-white text-sm px-4 py-1.5 rounded hover:bg-green-700">
                        Voir
                    </a>
                </div>
            </div>
        @endforeach
    </div>
@endif
@endsection
