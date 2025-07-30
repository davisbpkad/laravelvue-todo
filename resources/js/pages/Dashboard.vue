<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItemType } from '@/types';
import { Head } from '@inertiajs/vue3';
import { CheckSquare, Clock, AlertCircle, BarChart3 } from 'lucide-vue-next';

interface Props {
    stats?: {
        total: number;
        completed: number;
        incomplete: number;
        overdue: number;
    };
    isAdmin?: boolean;
}

const props = withDefaults(defineProps<Props>(), {
    stats: () => ({ total: 0, completed: 0, incomplete: 0, overdue: 0 }),
    isAdmin: false,
});

const breadcrumbs: BreadcrumbItemType[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 overflow-x-auto">
            <!-- Welcome Header -->
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-semibold text-foreground">Dashboard</h1>
                    <p class="text-sm text-muted-foreground mt-1">
                        {{ isAdmin ? 'Admin Overview - All Todos' : 'Your Todo Overview' }}
                    </p>
                </div>
                <div class="flex items-center space-x-2">
                    <a
                        href="/todos"
                        class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2"
                    >
                        <CheckSquare class="w-4 h-4 mr-2" />
                        View All Todos
                    </a>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="grid auto-rows-min gap-4 md:grid-cols-4">
                <div class="relative overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border p-6">
                    <div class="flex items-center">
                        <div class="p-2 bg-blue-100 dark:bg-blue-900 rounded-lg">
                            <BarChart3 class="w-6 h-6 text-blue-600 dark:text-blue-400" />
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-muted-foreground">Total Todos</p>
                            <p class="text-2xl font-bold text-foreground">{{ stats.total }}</p>
                        </div>
                    </div>
                </div>

                <div class="relative overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border p-6">
                    <div class="flex items-center">
                        <div class="p-2 bg-green-100 dark:bg-green-900 rounded-lg">
                            <CheckSquare class="w-6 h-6 text-green-600 dark:text-green-400" />
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-muted-foreground">Completed</p>
                            <p class="text-2xl font-bold text-foreground">{{ stats.completed }}</p>
                        </div>
                    </div>
                </div>

                <div class="relative overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border p-6">
                    <div class="flex items-center">
                        <div class="p-2 bg-yellow-100 dark:bg-yellow-900 rounded-lg">
                            <Clock class="w-6 h-6 text-yellow-600 dark:text-yellow-400" />
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-muted-foreground">Incomplete</p>
                            <p class="text-2xl font-bold text-foreground">{{ stats.incomplete }}</p>
                        </div>
                    </div>
                </div>

                <div class="relative overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border p-6">
                    <div class="flex items-center">
                        <div class="p-2 bg-red-100 dark:bg-red-900 rounded-lg">
                            <AlertCircle class="w-6 h-6 text-red-600 dark:text-red-400" />
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-muted-foreground">Overdue</p>
                            <p class="text-2xl font-bold text-foreground">{{ stats.overdue }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="relative rounded-xl border border-sidebar-border/70 dark:border-sidebar-border p-6">
                <h2 class="text-lg font-semibold text-foreground mb-4">Quick Actions</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <a
                        href="/todos?status=completed"
                        class="flex items-center p-4 rounded-lg border border-border hover:bg-accent hover:text-accent-foreground transition-colors"
                    >
                        <CheckSquare class="w-5 h-5 mr-3 text-green-600" />
                        <div>
                            <p class="font-medium">View Completed Todos</p>
                            <p class="text-sm text-muted-foreground">{{ stats.completed }} completed tasks</p>
                        </div>
                    </a>
                    
                    <a
                        href="/todos?status=incomplete"
                        class="flex items-center p-4 rounded-lg border border-border hover:bg-accent hover:text-accent-foreground transition-colors"
                    >
                        <Clock class="w-5 h-5 mr-3 text-yellow-600" />
                        <div>
                            <p class="font-medium">View Incomplete Todos</p>
                            <p class="text-sm text-muted-foreground">{{ stats.incomplete }} pending tasks</p>
                        </div>
                    </a>

                    <a
                        href="/todos?status=overdue"
                        class="flex items-center p-4 rounded-lg border border-border hover:bg-accent hover:text-accent-foreground transition-colors"
                    >
                        <AlertCircle class="w-5 h-5 mr-3 text-red-600" />
                        <div>
                            <p class="font-medium">View Overdue Todos</p>
                            <p class="text-sm text-muted-foreground">{{ stats.overdue }} overdue tasks</p>
                        </div>
                    </a>

                    
                </div>
            </div>

            <!-- Role Information -->
            <div class="relative rounded-xl border border-sidebar-border/70 dark:border-sidebar-border p-6">
                <h2 class="text-lg font-semibold text-foreground mb-4">Your Role & Permissions</h2>
                <div class="space-y-3">
                    <div class="flex items-center">
                        <div class="w-2 h-2 bg-blue-500 rounded-full mr-3"></div>
                        <span class="text-sm text-muted-foreground">
                            Role: <strong class="text-foreground">{{ isAdmin ? 'Administrator' : 'User' }}</strong>
                        </span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-2 h-2 bg-green-500 rounded-full mr-3"></div>
                        <span class="text-sm text-muted-foreground">
                            Can create, edit, and delete {{ isAdmin ? 'all todos' : 'your own todos' }}
                        </span>
                    </div>
                    <div v-if="isAdmin" class="flex items-center">
                        <div class="w-2 h-2 bg-purple-500 rounded-full mr-3"></div>
                        <span class="text-sm text-muted-foreground">
                            Can assign todos to other users and view all user todos
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
