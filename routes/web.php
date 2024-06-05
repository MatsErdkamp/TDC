<?php

use App\Http\Controllers\ProfileController;
use App\Models\Challenge;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\SubmissionController;

Route::get('/', function () {
    $today = now()->toDateString();
    $yesterday = now()->subDay()->toDateString();

    $todaysChallenge = Challenge::with(['submissions.user', 'winnerSubmission.user'])
        ->whereDate('date', $today)
        ->first();

    $yesterdaysChallenge = Challenge::with(['submissions.user', 'winnerSubmission.user'])
        ->whereDate('date', $yesterday)
        ->first();

    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'todaysChallenge' => $todaysChallenge,
        'yesterdaysChallenge' => $yesterdaysChallenge,
    ]);
});

Route::middleware('auth')->group(function () {
    Route::post('/submission', [SubmissionController::class, 'store']);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
