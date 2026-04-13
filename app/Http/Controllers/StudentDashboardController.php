<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class StudentDashboardController extends Controller
{
    public function index()
    {
        $student = Auth::user()->student;

        $participations = $student->participations()
            ->with('event')
            ->latest()
            ->get();

        $upcomingEvents = $participations
            ->filter(fn($p) => $p->event->date_event->isFuture())
            ->values();

        $transactions = $student->transactions()
            ->with('reward')
            ->latest()
            ->get();

        return view('student.dashboard', compact('student', 'upcomingEvents', 'transactions'));
    }
}
