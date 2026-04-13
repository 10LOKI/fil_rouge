<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Partner;
use App\Models\Participation;
use App\Models\User;

class HomeController extends Controller
{
    public function index()
    {
        $stats = [
            'students'       => \Spatie\Permission\Models\Role::findByName('student')->users()->count(),
            'participations' => Participation::count(),
            'partners'       => Partner::count(),
        ];

        $events   = Event::with('partner')->where('status', 'active')->latest('date_event')->take(6)->get();
        $partners = Partner::with('user')->take(6)->get();

        return view('welcome', compact('stats', 'events', 'partners'));
    }
}
