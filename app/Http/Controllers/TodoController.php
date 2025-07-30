<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use App\Models\User;
use App\Http\Requests\StoreTodoRequest;
use App\Http\Requests\UpdateTodoRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $query = Todo::with('user');

        // If user is not admin, only show their todos
        if (!$user->isAdmin()) {
            $query->where('user_id', $user->id);
        }

        // Apply filters
        if ($request->filled('status')) {
            switch ($request->status) {
                case 'completed':
                    $query->completed();
                    break;
                case 'incomplete':
                    $query->incomplete();
                    break;
                case 'overdue':
                    $query->overdue();
                    break;
            }
        }

        if ($request->filled('user_id')) {
            $query->forUser($request->user_id);
        }

        $todos = $query->orderBy('created_at', 'desc')->get();

        // Add is_overdue attribute to each todo
        $todos->each(function ($todo) {
            $todo->is_overdue = $todo->isOverdue();
        });

        // Get all users for filter dropdown (only for admins)
        $users = $user->isAdmin() ? User::select('id', 'name')->get() : collect();

        return Inertia::render('Todos/Index', [
            'todos' => $todos,
            'users' => $users,
            'filters' => [
                'status' => $request->status,
                'user_id' => $request->user_id,
            ],
            'isAdmin' => $user->isAdmin(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTodoRequest $request)
    {
        $data = $request->validated();
        
        // If not admin, force user_id to current user
        if (!auth()->user()->isAdmin()) {
            $data['user_id'] = auth()->id();
        } else {
            // If admin doesn't specify user_id, use current user
            $data['user_id'] = $data['user_id'] ?? auth()->id();
        }

        $todo = Todo::create($data);

        return redirect()->back()->with('success', 'Todo created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Todo $todo)
    {
        $user = auth()->user();
        
        // Check if user can view this todo
        if (!$user->isAdmin() && $todo->user_id !== $user->id) {
            abort(403, 'Unauthorized to view this todo.');
        }

        return Inertia::render('Todos/Show', [
            'todo' => $todo->load('user'),
            'isAdmin' => $user->isAdmin(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTodoRequest $request, Todo $todo)
    {
        $data = $request->validated();
        
        // If not admin, prevent changing user_id
        if (!auth()->user()->isAdmin()) {
            unset($data['user_id']);
        }

        $todo->update($data);

        return redirect()->back()->with('success', 'Todo updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Todo $todo)
    {
        $user = auth()->user();
        
        // Check if user can delete this todo
        if (!$user->isAdmin() && $todo->user_id !== $user->id) {
            abort(403, 'Unauthorized to delete this todo.');
        }

        $todo->delete();

        return redirect()->back()->with('success', 'Todo deleted successfully!');
    }

    /**
     * Toggle completion status
     */
    public function toggleComplete(Todo $todo)
    {
        $user = auth()->user();
        
        // Check if user can update this todo
        if (!$user->isAdmin() && $todo->user_id !== $user->id) {
            abort(403, 'Unauthorized to update this todo.');
        }

        $todo->update(['completed' => !$todo->completed]);

        return redirect()->back()->with('success', 'Todo status updated!');
    }
}
