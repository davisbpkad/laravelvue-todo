<template>
  <div
    class="border border-border rounded-lg p-4 hover:shadow-md transition-shadow"
    :class="{
      'bg-green-50 border-green-200 dark:bg-green-950 dark:border-green-800': todo.completed,
      'bg-red-50 border-red-200 dark:bg-red-950 dark:border-red-800': todo.is_overdue,
    }"
  >
    <!-- Mobile Layout (< md screens) -->
    <div class="block md:hidden">
      <!-- Content Section -->
      <div class="mb-4">
        <div class="flex items-center space-x-2 mb-2">
          <h3
            class="text-base font-medium flex-1"
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
        </div>
        
        <!-- Status badges -->
        <div class="flex flex-wrap gap-1 mb-2">
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
        
        <p v-if="todo.description" class="text-muted-foreground mb-3 text-sm">
          {{ todo.description }}
        </p>
        
        <div class="flex flex-col space-y-1 text-xs text-muted-foreground">
          <span v-if="isAdmin">
            <i class="fas fa-user mr-1"></i>
            <strong>User:</strong> {{ todo.user.name }}
          </span>
          <span v-if="todo.due_date">
            <i class="fas fa-calendar mr-1"></i>
            <strong>Due:</strong> {{ formatDate(todo.due_date) }}
          </span>
          <span>
            <i class="fas fa-clock mr-1"></i>
            <strong>Created:</strong> {{ formatDate(todo.created_at) }}
          </span>
        </div>
      </div>

      <!-- Mobile Actions - Full Width Buttons -->
      <div class="grid grid-cols-3 gap-2">
        <button
          @click="$emit('toggleComplete', todo)"
          :class="{
            'bg-green-400 hover:bg-green-500': !todo.completed,
            'bg-gray-400 hover:bg-gray-500': todo.completed,
          }"
          class="inline-flex items-center justify-center whitespace-nowrap
          rounded-lg text-xs font-medium
          h-10 px-2
          ring-offset-background transition-all
          focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2
          disabled:pointer-events-none disabled:opacity-50
          text-black
          shadow-[3px_3px_0_0_#000] border-2 border-black
          active:shadow-[1px_1px_0_0_#000]
          hover:shadow-[1px_1px_0_0_rgba(0,0,0,1)]
          hover:translate-x-[1px] hover:translate-y-[1px]"
        >
          <i :class="['fas', todo.completed ? 'fa-times' : 'fa-check']" class="text-sm"></i>
          <span class="ml-1 hidden xs:inline">{{ todo.completed ? 'Undo' : 'Done' }}</span>
        </button>
        
        <button
          @click="$emit('edit', todo)"
          class="inline-flex items-center justify-center whitespace-nowrap
          rounded-lg text-xs font-medium h-10 px-2
          transition-all ring-offset-background
          focus-visible:outline-none focus-visible:ring-2
          focus-visible:ring-ring focus-visible:ring-offset-2
          disabled:pointer-events-none disabled:opacity-50
          bg-blue-400 hover:bg-blue-500 text-black
          shadow-[3px_3px_0_0_#000] border-2 border-black
          active:shadow-[1px_1px_0_0_#000]
          hover:shadow-[1px_1px_0_0_rgba(0,0,0,1)]
          hover:translate-x-[1px] hover:translate-y-[1px]"
        >
          <i class="fas fa-edit text-sm"></i>
          <span class="ml-1 hidden xs:inline">Edit</span>
        </button>
        
        <button
          @click="$emit('delete', todo)"
          class="inline-flex items-center justify-center whitespace-nowrap
          rounded-lg text-xs font-medium h-10 px-2
          transition-all ring-offset-background
          focus-visible:outline-none focus-visible:ring-2
          focus-visible:ring-ring focus-visible:ring-offset-2
          disabled:pointer-events-none disabled:opacity-50
          bg-red-400 hover:bg-red-500 text-black
          shadow-[3px_3px_0_0_#000] border-2 border-black
          active:shadow-[1px_1px_0_0_#000]
          hover:shadow-[1px_1px_0_0_rgba(0,0,0,1)]
          hover:translate-x-[1px] hover:translate-y-[1px]"
        >
          <i class="fas fa-trash text-sm"></i>
          <span class="ml-1 hidden xs:inline">Delete</span>
        </button>
      </div>
    </div>

    <!-- Desktop Layout (>= md screens) -->
    <div class="hidden md:flex items-start justify-between">
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
            <i class="fas fa-user mr-1"></i>
            <strong>User:</strong> {{ todo.user.name }}
          </span>
          <span v-if="todo.due_date">
            <i class="fas fa-calendar mr-1"></i>
            <strong>Due:</strong> {{ formatDate(todo.due_date) }}
          </span>
          <span>
            <i class="fas fa-clock mr-1"></i>
            <strong>Created:</strong> {{ formatDate(todo.created_at) }}
          </span>
        </div>
      </div>

      <!-- Desktop Actions -->
      <div class="flex items-center space-x-2 ml-4">
        <button
          @click="$emit('toggleComplete', todo)"
          :class="{
            'bg-green-400 hover:bg-green-500': !todo.completed,
            'bg-gray-400 hover:bg-gray-500': todo.completed,
          }"
          class="inline-flex items-center justify-center whitespace-nowrap
          rounded-lg text-sm font-medium
          h-9 px-3
          ring-offset-background transition-all
          focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2
          disabled:pointer-events-none disabled:opacity-50
          text-black
          shadow-[4px_4px_0_0_#000] border-2 border-black
          active:shadow-[2px_2px_0_0_#000]
          hover:shadow-[1px_1px_0_0_rgba(0,0,0,1)]
          hover:translate-x-[2px] hover:translate-y-[2px]"
        >
          <i :class="['mr-2', 'fas', todo.completed ? 'fa-times' : 'fa-check']"></i>
          {{ todo.completed ? 'Undo' : 'Complete' }}
        </button>
        
        <button
          @click="$emit('edit', todo)"
          class="inline-flex items-center justify-center whitespace-nowrap
          rounded-lg text-sm font-medium h-9 px-3
          transition-all ring-offset-background
          focus-visible:outline-none focus-visible:ring-2
          focus-visible:ring-ring focus-visible:ring-offset-2
          disabled:pointer-events-none disabled:opacity-50
          bg-blue-400 hover:bg-blue-500 text-black
          shadow-[4px_4px_0_0_#000] border-2 border-black
          active:shadow-[2px_2px_0_0_#000]
          hover:shadow-[1px_1px_0_0_rgba(0,0,0,1)]
          hover:translate-x-[2px] hover:translate-y-[2px]"
        >
          <i class="fas fa-edit mr-2"></i>
          Edit
        </button>
        
        <button
          @click="$emit('delete', todo)"
          class="inline-flex items-center justify-center whitespace-nowrap
          rounded-lg text-sm font-medium h-9 px-3
          transition-all ring-offset-background
          focus-visible:outline-none focus-visible:ring-2
          focus-visible:ring-ring focus-visible:ring-offset-2
          disabled:pointer-events-none disabled:opacity-50
          bg-red-400 hover:bg-red-500 text-black
          shadow-[4px_4px_0_0_#000] border-2 border-black
          active:shadow-[2px_2px_0_0_#000]
          hover:shadow-[1px_1px_0_0_rgba(0,0,0,1)]
          hover:translate-x-[2px] hover:translate-y-[2px]"
        >
          <i class="fas fa-trash mr-2"></i>
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