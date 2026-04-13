<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RewardController;
use App\Http\Controllers\StudentDashboardController;
use Illuminate\Support\Facades\Route;

// Landing page
Route::get('/', [HomeController::class, 'index'])->name('home');

// Auth
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Events (public catalogue)
Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');

// Student
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [StudentDashboardController::class, 'index'])->name('student.dashboard');
    Route::post('/events/{event}/join', [EventController::class, 'join'])->name('events.join');
    Route::get('/rewards', [RewardController::class, 'index'])->name('rewards.index');
    Route::post('/rewards/{reward}/redeem', [RewardController::class, 'redeem'])->name('rewards.redeem');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

// Partner
Route::middleware(['auth', 'role:partner'])->prefix('partner')->name('partner.')->group(function () {
    Route::get('/dashboard', [PartnerController::class, 'dashboard'])->name('dashboard');
    Route::post('/events', [PartnerController::class, 'createEvent'])->name('events.store');
    Route::post('/rewards', [PartnerController::class, 'createReward'])->name('rewards.store');
});

// Page publique partenaire
Route::get('/partners/{partner}', [PartnerController::class, 'show'])->name('partner.show');

// Admin
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    Route::get('/users', [AdminController::class, 'users'])->name('users.index');
    Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('users.destroy');

    Route::get('/events', [AdminController::class, 'events'])->name('events.index');
    Route::post('/events', [AdminController::class, 'storeEvent'])->name('events.store');
    Route::delete('/events/{event}', [AdminController::class, 'deleteEvent'])->name('events.destroy');

    Route::get('/rewards', [AdminController::class, 'rewards'])->name('rewards.index');
    Route::post('/rewards', [AdminController::class, 'storeReward'])->name('rewards.store');
    Route::delete('/rewards/{reward}', [AdminController::class, 'deleteReward'])->name('rewards.destroy');

    Route::post('/participations/{participation}/validate', [AdminController::class, 'validateParticipation'])->name('participations.validate');
});
