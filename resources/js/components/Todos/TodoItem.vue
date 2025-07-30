<template>
  <div
    class="border border-border rounded-lg p-4 hover:shadow-md transition-shadow"
    :class="{
      'bg-green-50 border-green-200 dark:bg-green-950 dark:border-green-800': todo.completed,
      'bg-red-50 border-red-200 dark:bg-red-950 dark:border-red-800': todo.is_overdue,
    }"
  >
    <div class="flex items-start justify-between">
      <div class="flex-1">
        <div class="flex items-center space-x-2 mb-2">
          <h3
            class="text-lg font-medium"
            :class="{
              'line-through text-muted-foreground': todo.completed,
              'text-foreground': !todo.completed,
            }"
          >
            {{ todo.title }}
          </h3>
          <span
            :class="{
              'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200': todo.priority === 'low',
              'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200': todo.priority === 'medium',
              'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200': todo.priority === 'high',
            }"
            class="px-2 py-1 text-xs font-semibold rounded-full"
          >
            {{ todo.priority }}
          </span>
          <span
            v-if="todo.completed"
            class="bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 px-2 py-1 text-xs font-semibold rounded-full"
          >
            Completed
          </span>
          <span
            v-else-if="todo.is_overdue"
            class="bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200 px-2 py-1 text-xs font-semibold rounded-full"
          >
            Overdue
          </span>
        </div>
        
        <p v-if="todo.description" class="text-muted-foreground mb-3">
          {{ todo.description }}
        </p>
        
        <div class="flex items-center space-x-4 text-sm text-muted-foreground">
          <span v-if="isAdmin">
            <strong>User:</strong> {{ todo.user.name }}
          </span>
          <span v-if="todo.due_date">
            <strong>Due:</strong> {{ formatDate(todo.due_date) }}
          </span>
          <span>
            <strong>Created:</strong> {{ formatDate(todo.created_at) }}
          </span>
        </div>
      </div>

      <!-- Actions -->
      <div class="flex items-center space-x-2 ml-4">
        <button
          @click="$emit('toggleComplete', todo)"
          :class="{
            'bg-green-600 hover:bg-green-700': !todo.completed,
            'bg-gray-600 hover:bg-gray-700': todo.completed,
          }"
          class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 text-primary-foreground h-9 px-3"
        >
          {{ todo.completed ? 'Mark Incomplete' : 'Mark Complete' }}
        </button>
        
        <button
          @click="$emit('edit', todo)"
          class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-9 px-3"
        >
          Edit
        </button>
        
        <button
          @click="$emit('delete', todo)"
          class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-destructive text-destructive-foreground hover:bg-destructive/90 h-9 px-3"
        >
          Delete
        </button>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
interface User {
  id: number
  name: string
}

interface Todo {
  id: number
  title: string
  description?: string
  completed: boolean
  priority: 'low' | 'medium' | 'high'
  due_date?: string
  user_id: number
  user: User
  is_overdue: boolean
  created_at: string
}

interface Props {
  todo: Todo
  isAdmin: boolean
}

defineProps<Props>()
defineEmits<{
  toggleComplete: [todo: Todo]
  edit: [todo: Todo]
  delete: [todo: Todo]
}>()

const formatDate = (dateString: string) => {
  if (!dateString) return ''
  return new Date(dateString).toLocaleDateString()
}
</script>