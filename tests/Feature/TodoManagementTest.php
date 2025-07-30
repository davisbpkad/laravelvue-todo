<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Todo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TodoManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_todo()
    {
        $user = User::factory()->create(['role' => 'user']);
        
        $response = $this->actingAs($user)->post('/todos', [
            'title' => 'Test Todo',
            'description' => 'This is a test todo',
            'priority' => 'high',
            'due_date' => now()->addDays(3)->format('Y-m-d'),
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('todos', [
            'title' => 'Test Todo',
            'user_id' => $user->id,
        ]);
    }

    public function test_user_cannot_see_other_users_todos()
    {
        $user1 = User::factory()->create(['role' => 'user']);
        $user2 = User::factory()->create(['role' => 'user']);
        
        $todo1 = Todo::factory()->create(['user_id' => $user1->id]);
        $todo2 = Todo::factory()->create(['user_id' => $user2->id]);

        $response = $this->actingAs($user1)->get('/todos');
        
        $response->assertInertia(fn ($page) => 
            $page->component('Todos/Index')
                ->has('todos', 1)
                ->where('todos.0.id', $todo1->id)
        );
    }

    public function test_admin_can_see_all_todos()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create(['role' => 'user']);
        
        $adminTodo = Todo::factory()->create(['user_id' => $admin->id]);
        $userTodo = Todo::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($admin)->get('/todos');
        
        $response->assertInertia(fn ($page) => 
            $page->component('Todos/Index')
                ->has('todos', 2)
        );
    }

    public function test_user_cannot_update_other_users_todo()
    {
        $user1 = User::factory()->create(['role' => 'user']);
        $user2 = User::factory()->create(['role' => 'user']);
        
        $todo = Todo::factory()->create(['user_id' => $user2->id]);

        $response = $this->actingAs($user1)->put("/todos/{$todo->id}", [
            'title' => 'Updated Title',
        ]);

        $response->assertStatus(403);
    }

    public function test_admin_can_update_any_todo()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create(['role' => 'user']);
        
        $todo = Todo::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($admin)->put("/todos/{$todo->id}", [
            'title' => 'Updated by Admin',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('todos', [
            'id' => $todo->id,
            'title' => 'Updated by Admin',
        ]);
    }

    public function test_todo_filtering_by_status()
    {
        $user = User::factory()->create(['role' => 'user']);
        
        Todo::factory()->create(['user_id' => $user->id, 'completed' => true]);
        Todo::factory()->create(['user_id' => $user->id, 'completed' => false]);
        Todo::factory()->create(['user_id' => $user->id, 'completed' => false, 'due_date' => now()->subDays(1)]);

        // Test completed filter
        $response = $this->actingAs($user)->get('/todos?status=completed');
        $response->assertInertia(fn ($page) => $page->has('todos', 1));

        // Test incomplete filter
        $response = $this->actingAs($user)->get('/todos?status=incomplete');
        $response->assertInertia(fn ($page) => $page->has('todos', 2));

        // Test overdue filter
        $response = $this->actingAs($user)->get('/todos?status=overdue');
        $response->assertInertia(fn ($page) => $page->has('todos', 1));
    }

    public function test_admin_can_filter_by_user()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user1 = User::factory()->create(['role' => 'user']);
        $user2 = User::factory()->create(['role' => 'user']);
        
        Todo::factory()->create(['user_id' => $user1->id]);
        Todo::factory()->create(['user_id' => $user1->id]);
        Todo::factory()->create(['user_id' => $user2->id]);

        $response = $this->actingAs($admin)->get("/todos?user_id={$user1->id}");
        
        $response->assertInertia(fn ($page) => 
            $page->component('Todos/Index')
                ->has('todos', 2)
        );
    }
}
