<template>
  <div v-if="isVisible" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-background border border-border p-6 rounded-lg w-full max-w-md mx-4">
      <h2 class="text-xl font-bold mb-4 text-foreground">
        {{ editingTodo ? 'Edit Todo' : 'Create New Todo' }}
      </h2>
      
      <form @submit.prevent="$emit('submit', form)">
        <div class="mb-4">
          <label class="block text-sm font-medium text-foreground mb-2">Title</label>
          <input
            v-model="form.title"
            type="text"
            required
            class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
          />
        </div>

        <div class="mb-4">
          <label class="block text-sm font-medium text-foreground mb-2">Description</label>
          <textarea
            v-model="form.description"
            rows="3"
            class="flex min-h-[80px] w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
          ></textarea>
        </div>

        <div class="mb-4">
          <label class="block text-sm font-medium text-foreground mb-2">Priority</label>
          <select
            v-model="form.priority"
            class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
          >
            <option value="low">Low</option>
            <option value="medium">Medium</option>
            <option value="high">High</option>
          </select>
        </div>

        <div class="mb-4">
          <label class="block text-sm font-medium text-foreground mb-2">Due Date</label>
          <input
            v-model="form.due_date"
            type="date"
            class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
          />
        </div>

        <div v-if="isAdmin" class="mb-4">
          <label class="block text-sm font-medium text-foreground mb-2">Assign to User</label>
          <select
            v-model="form.user_id"
            class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
          >
            <option value="">Select User</option>
            <option v-for="user in users" :key="user.id" :value="user.id">
              {{ user.name }}
            </option>
          </select>
        </div>

        <div v-if="editingTodo" class="mb-4">
          <label class="flex items-center">
            <input
              v-model="form.completed"
              type="checkbox"
              class="mr-2 h-4 w-4 rounded border border-primary text-primary focus:ring-2 focus:ring-ring"
            />
            <span class="text-sm font-medium text-foreground">Mark as completed</span>
          </label>
        </div>

        <div class="flex justify-end space-x-2">
          <button
            type="button"
            @click="$emit('cancel')"
            class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-10 px-4 py-2"
          >
            Cancel
          </button>
          <button
            type="submit"
            :disabled="processing"
            class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2"
          >
            {{ processing ? 'Saving...' : (editingTodo ? 'Update' : 'Create') }}
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup lang="ts">
import { reactive, watch } from 'vue'

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
  isVisible: boolean
  editingTodo: Todo | null
  users: User[]
  isAdmin: boolean
  processing: boolean
}

const props = defineProps<Props>()

defineEmits<{
  submit: [form: any]
  cancel: []
}>()

const form = reactive({
  title: '',
  description: '',
  priority: 'medium' as 'low' | 'medium' | 'high',
  due_date: '',
  user_id: '',
  completed: false,
})

const resetForm = () => {
  form.title = ''
  form.description = ''
  form.priority = 'medium'
  form.due_date = ''
  form.user_id = ''
  form.completed = false
}

watch(() => props.editingTodo, (todo) => {
  if (todo) {
    form.title = todo.title
    form.description = todo.description || ''
    form.priority = todo.priority
    form.due_date = todo.due_date || ''
    form.user_id = todo.user_id.toString()
    form.completed = todo.completed
  } else {
    resetForm()
  }
}, { immediate: true })
</script>