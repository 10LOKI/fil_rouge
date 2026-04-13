<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Reward;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PartnerController extends Controller
{
    public function show(\App\Models\Partner $partner)
    {
        $events  = $partner->events()->where('status', 'active')->latest('date_event')->get();
        $rewards = $partner->rewards()->where('stock_quantity', '>', 0)->get();

        return view('partner.show', compact('partner', 'events', 'rewards'));
    }

    public function dashboard()
    {
        $partner = Auth::user()->partner;

        $events  = $partner->events()->withCount('participations')->latest()->get();
        $rewards = $partner->rewards()->latest()->get();

        $totalStudentsHelped = $events->sum('participations_count');
        $totalPointsFunded   = $partner->events()->sum('points_worth');

        return view('partner.dashboard', compact('partner', 'events', 'rewards', 'totalStudentsHelped', 'totalPointsFunded'));
    }

    public function createEvent(Request $request)
    {
        $data = $request->validate([
            'title'        => 'required|string|max:255',
            'category'     => 'required|string|max:100',
            'date_event'   => 'required|date|after:now',
            'points_worth' => 'required|integer|min:1',
        ]);

        Auth::user()->partner->events()->create($data);

        return back()->with('success', 'Événement créé avec succès.');
    }

    public function createReward(Request $request)
    {
        $data = $request->validate([
            'label'          => 'required|string|max:255',
            'cost_points'    => 'required|integer|min:1',
            'promo_code'     => 'nullable|string|max:100',
            'stock_quantity' => 'required|integer|min:1',
        ]);

        Auth::user()->partner->rewards()->create($data);

        return back()->with('success', 'Récompense ajoutée avec succès.');
    }
}
