@extends('layouts.app')
@section('title', 'Récompenses')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold">Catalogue des récompenses</h1>
    @auth
        @if(Auth::user()->hasRole('student'))
            <span class="bg-green-100 text-green-700 px-3 py-1 rounded text-sm font-semibold">
                {{ Auth::user()->student->total_points }} pts disponibles
            </span>
        @endif
    @endauth
</div>

@if($rewards->isEmpty())
    <p class="text-gray-500 text-center py-12">Aucune récompense disponible pour le moment.</p>
@else
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($rewards as $reward)
            <div class="bg-white rounded shadow p-5 flex flex-col gap-3">
                <p class="text-xs text-gray-400">{{ $reward->partner->company_name }}</p>
                <h2 class="font-semibold text-lg">{{ $reward->label }}</h2>
                <div class="flex items-center justify-between mt-auto">
                    <span class="text-green-600 font-bold">{{ $reward->cost_points }} pts</span>
                    <span class="text-xs text-gray-400">Stock : {{ $reward->stock_quantity }}</span>
                </div>
                @auth
                    @if(Auth::user()->hasRole('student'))
                        <form method="POST" action="{{ route('rewards.redeem', $reward) }}">
                            @csrf
                            <button
                                class="w-full bg-green-600 text-white py-2 rounded hover:bg-green-700 text-sm disabled:opacity-50"
                                {{ Auth::user()->student->total_points < $reward->cost_points ? 'disabled' : '' }}>
                                Échanger
                            </button>
                        </form>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="block text-center bg-gray-100 text-gray-600 py-2 rounded text-sm hover:bg-gray-200">
                        Connectez-vous pour échanger
                    </a>
                @endauth
            </div>
        @endforeach
    </div>
@endif
@endsection
