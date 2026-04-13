@extends('layouts.app')
@section('title', $partner->company_name)

@section('content')
<div class="max-w-3xl mx-auto">

    {{-- Header partenaire --}}
    <div class="bg-white rounded shadow p-8 mb-6 flex items-center gap-6">
        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center text-green-700 font-bold text-2xl flex-shrink-0">
            {{ strtoupper(substr($partner->company_name, 0, 1)) }}
        </div>
        <div>
            <h1 class="text-2xl font-bold">{{ $partner->company_name }}</h1>
            @if($partner->rse_bio)
                <p class="text-gray-500 mt-1">{{ $partner->rse_bio }}</p>
            @endif
        </div>
    </div>

    {{-- Événements actifs --}}
    <div class="bg-white rounded shadow p-6 mb-6">
        <h2 class="font-semibold text-lg mb-4">Événements organisés</h2>
        @if($events->isEmpty())
            <p class="text-gray-400 text-sm">Aucun événement actif.</p>
        @else
            <ul class="divide-y">
                @foreach($events as $event)
                    <li class="py-3 flex items-center justify-between">
                        <div>
                            <p class="font-medium">{{ $event->title }}</p>
                            <p class="text-xs text-gray-400">{{ $event->date_event->format('d/m/Y') }} · {{ $event->category }}</p>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="text-green-600 text-sm font-semibold">+{{ $event->points_worth }} pts</span>
                            <a href="{{ route('events.show', $event) }}" class="text-sm text-green-600 hover:underline">Voir →</a>
                        </div>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>

    {{-- Récompenses --}}
    <div class="bg-white rounded shadow p-6">
        <h2 class="font-semibold text-lg mb-4">Récompenses offertes</h2>
        @if($rewards->isEmpty())
            <p class="text-gray-400 text-sm">Aucune récompense disponible.</p>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($rewards as $reward)
                    <div class="border rounded-xl p-4 flex items-center justify-between">
                        <p class="font-medium text-sm">{{ $reward->label }}</p>
                        <span class="text-green-600 font-bold text-sm">{{ $reward->cost_points }} pts</span>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

</div>
@endsection
