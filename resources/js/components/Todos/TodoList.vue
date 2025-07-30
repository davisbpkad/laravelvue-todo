<template>
  <div class="rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
    <div class="p-4">
      <div v-if="todos.length === 0" class="text-center py-8">
        <p class="text-muted-foreground">No todos found.</p>
      </div>
      <div v-else class="space-y-4">
        <TodoItem
          v-for="todo in todos"
          :key="todo.id"
          :todo="todo"
          :is-admin="isAdmin"
          @toggle-complete="$emit('toggleComplete', $event)"
          @edit="$emit('edit', $event)"
          @delete="$emit('delete', $event)"
        />
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import TodoItem from './TodoItem.vue'

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
  todos: Todo[]
  isAdmin: boolean
}

defineProps<Props>()
defineEmits<{
  toggleComplete: [todo: Todo]
  edit: [todo: Todo]
  delete: [todo: Todo]
}>()
</script>