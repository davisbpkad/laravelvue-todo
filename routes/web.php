<?php

use App\Http\Controllers\TodoController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        $user = auth()->user();
        $baseQuery = $user->isAdmin() ? \App\Models\Todo::query() : $user->todos();
        
        $stats = [
            'total' => (clone $baseQuery)->count(),
            'completed' => (clone $baseQuery)->where('completed', true)->count(),
            'incomplete' => (clone $baseQuery)->where('completed', false)->count(),
            'overdue' => (clone $baseQuery)->where('due_date', '<', now())->where('completed', false)->count(),
        ];
        
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
