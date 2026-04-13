<?php

namespace App\Http\Controllers;

use App\Actions\Event\JoinEventAction;
use App\Models\Event;
use App\Models\Participation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $events = Event::with('partner')
            ->when($request->category, fn($q) => $q->where('category', $request->category))
            ->where('status', 'active')
            ->latest('date_event')
            ->get();

        return view('events.index', compact('events'));
    }

    public function show(Event $event)
    {
        $event->load('partner');
        $alreadyJoined = false;

        if (Auth::check() && Auth::user()->hasRole('student')) {
            $alreadyJoined = Participation::where('student_id', Auth::user()->student->id)
                ->where('event_id', $event->id)
                ->exists();
        }

        return view('events.show', compact('event', 'alreadyJoined'));
    }

    public function join(Event $event, JoinEventAction $action)
    {
        try {
            $action->handle(Auth::user()->student, $event);
            return back()->with('success', 'Inscription confirmée !');
        } catch (\RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
