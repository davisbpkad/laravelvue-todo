<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Todo;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create an admin user
        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'role' => 'admin',
        ]);

        // Create regular users
        $user1 = User::factory()->create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'role' => 'user',
        ]);

        $user2 = User::factory()->create([
            'name' => 'Jane Smith',
            'email' => 'jane@example.com',
            'role' => 'user',
        ]);

        // Create todos for different users with various statuses
        Todo::factory()->create([
            'title' => 'Complete project documentation',
            'description' => 'Write comprehensive documentation for the project',
            'user_id' => $user1->id,
            'priority' => 'high',
            'due_date' => now()->addDays(3),
            'completed' => false,
        ]);

        Todo::factory()->create([
            'title' => 'Review pull requests',
            'description' => 'Review all pending pull requests',
            'user_id' => $user1->id,
            'priority' => 'medium',
            'due_date' => now()->addDays(1),
            'completed' => true,
        ]);

        Todo::factory()->create([
            'title' => 'Fix login bug',
            'description' => 'There is a bug in the login system that needs to be fixed',
            'user_id' => $user2->id,
            'priority' => 'high',
            'due_date' => now()->subDays(2), // Overdue
            'completed' => false,
        ]);

        Todo::factory()->create([
            'title' => 'Update user interface',
            'description' => 'Modernize the user interface with new design patterns',
            'user_id' => $user2->id,
            'priority' => 'low',
            'due_date' => now()->addWeek(),
            'completed' => false,
        ]);

        Todo::factory()->create([
            'title' => 'Database optimization',
            'description' => 'Optimize database queries for better performance',
            'user_id' => $admin->id,
            'priority' => 'medium',
            'due_date' => now()->addDays(5),
            'completed' => false,
        ]);

        Todo::factory()->create([
            'title' => 'Security audit',
            'description' => 'Conduct a thorough security audit of the application',
            'user_id' => $admin->id,
            'priority' => 'high',
            'due_date' => now()->subDays(1), // Overdue
            'completed' => false,
        ]);

        // Create additional random todos
        Todo::factory(10)->create();
    }
}
