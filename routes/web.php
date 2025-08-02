<?php

use App\Http\Controllers\TodoController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

// Authentication routes
Route::middleware(['auth', 'verified'])->group(function () {
   // Dashboard route
    Route::get('dashboard', function () {
        $user = auth()->user();
        $baseQuery = $user->isAdmin() ? \App\Models\Todo::query() : $user->todos();
        // Fetch statistics for the dashboard
        $stats = [
            'total' => (clone $baseQuery)->count(),
            'completed' => (clone $baseQuery)->where('completed', true)->count(),
            'incomplete' => (clone $baseQuery)->where('completed', false)->count(),
            'overdue' => (clone $baseQuery)->where('due_date', '<', now())->where('completed', false)->count(),
        ];
        // Render the dashboard view with stats
        return Inertia::render('Dashboard', [
            'stats' => $stats,
            'isAdmin' => $user->isAdmin(),
        ]);
    })->name('dashboard');

    // Todo routes
    Route::resource('todos', TodoController::class);
    Route::patch('todos/{todo}/toggle-complete', [TodoController::class, 'toggleComplete'])
        ->name('todos.toggle-complete');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
