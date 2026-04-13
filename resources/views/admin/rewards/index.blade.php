@extends('layouts.app')
@section('title', 'Récompenses — Admin')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold">Récompenses</h1>
    <a href="{{ route('admin.dashboard') }}" class="text-sm text-gray-400 hover:underline">← Dashboard</a>
</div>

<div class="bg-white rounded shadow overflow-hidden mb-8">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-left text-gray-500 border-b">
            <tr>
                <th class="px-4 py-3">Label</th>
                <th class="px-4 py-3">Partenaire</th>
                <th class="px-4 py-3">Coût (pts)</th>
                <th class="px-4 py-3">Stock</th>
                <th class="px-4 py-3">Action</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @foreach($rewards as $reward)
                <tr>
                    <td class="px-4 py-3">{{ $reward->label }}</td>
                    <td class="px-4 py-3">{{ $reward->partner->company_name }}</td>
                    <td class="px-4 py-3">{{ $reward->cost_points }}</td>
                    <td class="px-4 py-3">{{ $reward->stock_quantity }}</td>
                    <td class="px-4 py-3">
                        <form method="POST" action="{{ route('admin.rewards.destroy', $reward) }}"
                            onsubmit="return confirm('Supprimer cette récompense ?')">
                            @csrf @method('DELETE')
                            <button class="text-red-500 hover:underline text-xs">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="px-4 py-3">{{ $rewards->links() }}</div>
</div>
@endsection
