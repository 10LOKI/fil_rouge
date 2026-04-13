@extends('layouts.app')
@section('title', 'Admin Dashboard')

@section('content')
<h1 class="text-2xl font-bold mb-6">Administration</h1>

{{-- Stats globales --}}
<div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-8">
    @foreach([
        ['label' => 'Étudiants', 'value' => $stats['total_students'], 'color' => 'blue'],
        ['label' => 'Partenaires', 'value' => $stats['total_partners'], 'color' => 'purple'],
        ['label' => 'Événements', 'value' => $stats['total_events'], 'color' => 'green'],
        ['label' => 'Participations', 'value' => $stats['total_participations'], 'color' => 'yellow'],
        ['label' => 'Récompenses', 'value' => $stats['total_rewards'], 'color' => 'red'],
        ['label' => 'Transactions', 'value' => $stats['total_transactions'], 'color' => 'indigo'],
    ] as $stat)
        <div class="bg-white rounded shadow p-5 text-center">
            <p class="text-3xl font-bold text-{{ $stat['color'] }}-500">{{ $stat['value'] }}</p>
            <p class="text-sm text-gray-500 mt-1">{{ $stat['label'] }}</p>
        </div>
    @endforeach
</div>

{{-- Liens rapides --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <a href="{{ route('admin.users.index') }}"
        class="bg-white rounded shadow p-5 hover:shadow-md transition text-center font-semibold text-blue-600">
        👥 Gérer les utilisateurs
    </a>
    <a href="{{ route('admin.events.index') }}"
        class="bg-white rounded shadow p-5 hover:shadow-md transition text-center font-semibold text-green-600">
        📅 Gérer les événements
    </a>
    <a href="{{ route('admin.rewards.index') }}"
        class="bg-white rounded shadow p-5 hover:shadow-md transition text-center font-semibold text-purple-600">
        🎁 Gérer les récompenses
    </a>
</div>
@endsection
