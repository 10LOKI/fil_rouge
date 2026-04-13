@extends('layouts.app')
@section('title', 'Événements — Admin')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold">Événements</h1>
    <a href="{{ route('admin.dashboard') }}" class="text-sm text-gray-400 hover:underline">← Dashboard</a>
</div>

<div class="bg-white rounded shadow overflow-hidden mb-8">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-left text-gray-500 border-b">
            <tr>
                <th class="px-4 py-3">Titre</th>
                <th class="px-4 py-3">Partenaire</th>
                <th class="px-4 py-3">Catégorie</th>
                <th class="px-4 py-3">Date</th>
                <th class="px-4 py-3">Statut</th>
                <th class="px-4 py-3">Action</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @foreach($events as $event)
                <tr>
                    <td class="px-4 py-3">{{ $event->title }}</td>
                    <td class="px-4 py-3">{{ $event->partner->company_name }}</td>
                    <td class="px-4 py-3">{{ $event->category }}</td>
                    <td class="px-4 py-3">{{ $event->date_event->format('d/m/Y') }}</td>
                    <td class="px-4 py-3 capitalize">{{ $event->status }}</td>
                    <td class="px-4 py-3">
                        <form method="POST" action="{{ route('admin.events.destroy', $event) }}"
                            onsubmit="return confirm('Supprimer cet événement ?')">
                            @csrf @method('DELETE')
                            <button class="text-red-500 hover:underline text-xs">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="px-4 py-3">{{ $events->links() }}</div>
</div>

{{-- Valider participations --}}
<div class="bg-white rounded shadow p-6">
    <h2 class="font-semibold text-lg mb-4">Participations en attente de validation</h2>
    @php
        $pending = \App\Models\Participation::with(['student.user', 'event'])
            ->where('is_validated', false)->latest()->get();
    @endphp
    @if($pending->isEmpty())
        <p class="text-gray-400 text-sm">Aucune participation en attente.</p>
    @else
        <ul class="divide-y">
            @foreach($pending as $p)
                <li class="py-3 flex items-center justify-between">
                    <div>
                        <p class="font-medium">{{ $p->student->user->nom }} → {{ $p->event->title }}</p>
                        <p class="text-xs text-gray-400">{{ $p->joined_at->format('d/m/Y') }}</p>
                    </div>
                    <form method="POST" action="{{ route('admin.participations.validate', $p) }}">
                        @csrf
                        <button class="bg-green-600 text-white text-xs px-3 py-1 rounded hover:bg-green-700">
                            Valider (+{{ $p->event->points_worth }} pts)
                        </button>
                    </form>
                </li>
            @endforeach
        </ul>
    @endif
</div>
@endsection
