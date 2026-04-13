@extends('layouts.app')
@section('title', 'Espace Partenaire')

@section('content')
<h1 class="text-2xl font-bold mb-6">Espace Partenaire — {{ $partner->company_name }}</h1>

{{-- Impact Stats --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
    <div class="bg-white rounded shadow p-5 text-center">
        <p class="text-3xl font-bold text-blue-500">{{ $totalStudentsHelped }}</p>
        <p class="text-sm text-gray-500 mt-1">Étudiants aidés</p>
    </div>
    <div class="bg-white rounded shadow p-5 text-center">
        <p class="text-3xl font-bold text-green-600">{{ $totalPointsFunded }}</p>
        <p class="text-sm text-gray-500 mt-1">Points financés</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

    {{-- Créer un événement --}}
    <div class="bg-white rounded shadow p-6">
        <h2 class="font-semibold text-lg mb-4">Créer un événement</h2>
        <form method="POST" action="{{ route('partner.events.store') }}" class="space-y-3">
            @csrf
            <input type="text" name="title" placeholder="Titre" required
                class="w-full border rounded px-3 py-2 text-sm">
            <select name="category" required class="w-full border rounded px-3 py-2 text-sm">
                <option value="">Catégorie</option>
                @foreach(['Social', 'Animaux', 'Écologie'] as $cat)
                    <option value="{{ $cat }}">{{ $cat }}</option>
                @endforeach
            </select>
            <input type="datetime-local" name="date_event" required
                class="w-full border rounded px-3 py-2 text-sm">
            <input type="number" name="points_worth" placeholder="Points attribués" min="1" required
                class="w-full border rounded px-3 py-2 text-sm">
            <button class="w-full bg-green-600 text-white py-2 rounded hover:bg-green-700 text-sm">Créer</button>
        </form>
    </div>

    {{-- Créer une récompense --}}
    <div class="bg-white rounded shadow p-6">
        <h2 class="font-semibold text-lg mb-4">Ajouter une récompense</h2>
        <form method="POST" action="{{ route('partner.rewards.store') }}" class="space-y-3">
            @csrf
            <input type="text" name="label" placeholder="Nom de la récompense" required
                class="w-full border rounded px-3 py-2 text-sm">
            <input type="number" name="cost_points" placeholder="Coût en points" min="1" required
                class="w-full border rounded px-3 py-2 text-sm">
            <input type="text" name="promo_code" placeholder="Code promo (optionnel)"
                class="w-full border rounded px-3 py-2 text-sm">
            <input type="number" name="stock_quantity" placeholder="Quantité en stock" min="1" required
                class="w-full border rounded px-3 py-2 text-sm">
            <button class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 text-sm">Ajouter</button>
        </form>
    </div>
</div>

{{-- Mes événements --}}
<div class="bg-white rounded shadow p-6 mt-8">
    <h2 class="font-semibold text-lg mb-4">Mes événements</h2>
    @if($events->isEmpty())
        <p class="text-gray-400 text-sm">Aucun événement créé.</p>
    @else
        <table class="w-full text-sm">
            <thead class="text-left text-gray-500 border-b">
                <tr>
                    <th class="pb-2">Titre</th>
                    <th class="pb-2">Date</th>
                    <th class="pb-2">Participants</th>
                    <th class="pb-2">Statut</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @foreach($events as $event)
                    <tr>
                        <td class="py-2">{{ $event->title }}</td>
                        <td class="py-2">{{ $event->date_event->format('d/m/Y') }}</td>
                        <td class="py-2">{{ $event->participations_count }}</td>
                        <td class="py-2 capitalize">{{ $event->status }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
