<?php

namespace App\Http\Controllers;

use App\Actions\Event\ValidateParticipationAction;
use App\Models\Event;
use App\Models\Participation;
use App\Models\Reward;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_students'       => \Spatie\Permission\Models\Role::findByName('student')->users()->count(),
            'total_partners'       => \Spatie\Permission\Models\Role::findByName('partner')->users()->count(),
            'total_events'         => Event::count(),
            'total_participations' => Participation::count(),
            'total_transactions'   => Transaction::count(),
            'total_rewards'        => Reward::count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }

    // Users
    public function users()
    {
        $users = User::latest()->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    public function deleteUser(User $user)
    {
        $user->delete();
        return back()->with('success', 'Utilisateur supprimé.');
    }

    // Events
    public function events()
    {
        $events = Event::with('partner')->latest()->paginate(20);
        return view('admin.events.index', compact('events'));
    }

    public function storeEvent(Request $request)
    {
        $data = $request->validate([
            'partner_id'   => 'required|exists:partners,id',
            'title'        => 'required|string|max:255',
            'category'     => 'required|string|max:100',
            'date_event'   => 'required|date',
            'points_worth' => 'required|integer|min:0',
            'status'       => 'required|in:pending,active,completed,cancelled',
        ]);

        Event::create($data);
        return back()->with('success', 'Événement créé.');
    }

    public function deleteEvent(Event $event)
    {
        $event->delete();
        return back()->with('success', 'Événement supprimé.');
    }

    // Rewards
    public function rewards()
    {
        $rewards = Reward::with('partner')->latest()->paginate(20);
        return view('admin.rewards.index', compact('rewards'));
    }

    public function storeReward(Request $request)
    {
        $data = $request->validate([
            'partner_id'     => 'required|exists:partners,id',
            'label'          => 'required|string|max:255',
            'cost_points'    => 'required|integer|min:1',
            'promo_code'     => 'nullable|string|max:100',
            'stock_quantity' => 'required|integer|min:0',
        ]);

        Reward::create($data);
        return back()->with('success', 'Récompense ajoutée.');
    }

    public function deleteReward(Reward $reward)
    {
        $reward->delete();
        return back()->with('success', 'Récompense supprimée.');
    }

    // Participations
    public function validateParticipation(Participation $participation, ValidateParticipationAction $action)
    {
        try {
            $action->handle($participation);
            return back()->with('success', 'Participation validée, points attribués.');
        } catch (\RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
