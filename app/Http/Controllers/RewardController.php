<?php

namespace App\Http\Controllers;

use App\Actions\Reward\RedeemRewardAction;
use App\Models\Reward;
use Illuminate\Support\Facades\Auth;

class RewardController extends Controller
{
    public function index()
    {
        $rewards = Reward::with('partner')->where('stock_quantity', '>', 0)->get();

        return view('rewards.index', compact('rewards'));
    }

    public function redeem(Reward $reward, RedeemRewardAction $action)
    {
        try {
            $action->handle(Auth::user()->student, $reward);
            return back()->with('success', 'Récompense échangée avec succès !');
        } catch (\RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
