<template>
  <Head title="Todos" />
  
  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 overflow-x-auto">
      <!-- Header -->
      <div class="flex justify-between items-center">
        <div>
          <h1 class="text-2xl font-semibold text-foreground">
            Todo Management
          </h1>
          <p v-if="isAdmin" class="text-sm text-muted-foreground mt-1">
            Admin View - You can see and manage all todos
          </p>
        </div>
        <button
          @click="showCreateForm = true"
          class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2"
        >
          Add New Todo
        </button>
      </div>

      <!-- Filters -->
      <div class="rounded-xl border border-sidebar-border/70 p-4 dark:border-sidebar-border">
        <h2 class="text-lg font-medium text-foreground mb-4">Filters</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <!-- Status Filter -->
          <div>
            <label class="block text-sm font-medium text-foreground mb-2">Filter by Status</label>
            <select
              v-model="selectedStatus"
              @change="applyFilters"
              class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
            >
              <option value="">All Status</option>
              <option value="completed">Completed</option>
              <option value="incomplete">Incomplete</option>
              <option value="overdue">Overdue</option>
            </select>
          </div>

          <!-- User Filter (Admin only) -->
          <div v-if="isAdmin">
            <label class="block text-sm font-medium text-foreground mb-2">Filter by User</label>
            <select
              v-model="selectedUserId"
              @change="applyFilters"
              class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
            >
              <option value="">All Users</option>
              <option v-for="user in users" :key="user.id" :value="user.id">
                {{ user.name }}
              </option>
            </select>
          </div>
        </div>
      </div>

      <!-- Todo List -->
      <div class="rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
        <div class="p-4">
          <div v-if="todos.length === 0" class="text-center py-8">
            <p class="text-muted-foreground">No todos found.</p>
          </div>
          <div v-else class="space-y-4">
            <div
              v-for="todo in todos"
              :key="todo.id"
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
                    @click="toggleComplete(todo)"
                    :class="{
                      'bg-green-600 hover:bg-green-700': !todo.completed,
                      'bg-gray-600 hover:bg-gray-700': todo.completed,
                    }"
                    class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 text-primary-foreground h-9 px-3"
                  >
                    {{ todo.completed ? 'Mark Incomplete' : 'Mark Complete' }}
                  </button>
                  
                  <button
                    @click="editTodo(todo)"
                    class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-9 px-3"
                  >
                    Edit
                  </button>
                  
                  <button
                    @click="deleteTodo(todo)"
                    class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-destructive text-destructive-foreground hover:bg-destructive/90 h-9 px-3"
                  >
                    Delete
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Create/Edit Modal -->
      <div v-if="showCreateForm || editingTodo" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-background border border-border p-6 rounded-lg w-full max-w-md mx-4">
          <h2 class="text-xl font-bold mb-4 text-foreground">
            {{ editingTodo ? 'Edit Todo' : 'Create New Todo' }}
          </h2>
          
          <form @submit.prevent="submitForm">
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
                @click="cancelForm"
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
    </div>
  </AppLayout>
</template>

<script setup lang="ts">
import { ref, reactive } from 'vue'
import { router, Head } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'
import type { BreadcrumbItemType } from '@/types'

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
  users: User[]
  filters: {
    status?: string
    user_id?: string
  }
  isAdmin: boolean
}

const props = defineProps<Props>()

const breadcrumbs: BreadcrumbItemType[] = [
  {
    title: 'Dashboard',
    href: '/dashboard',
  },
  {
    title: 'Todos',
    href: '/todos',
  },
]

const showCreateForm = ref(false)
const editingTodo = ref<Todo | null>(null)
const processing = ref(false)
const selectedStatus = ref(props.filters.status || '')
const selectedUserId = ref(props.filters.user_id || '')

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

const editTodo = (todo: Todo) => {
  editingTodo.value = todo
  form.title = todo.title
  form.description = todo.description || ''
  form.priority = todo.priority
  form.due_date = todo.due_date || ''
  form.user_id = todo.user_id.toString()
  form.completed = todo.completed
}

const cancelForm = () => {
  showCreateForm.value = false
  editingTodo.value = null
  resetForm()
}

const submitForm = () => {
  processing.value = true
  
  const formData = {
    ...form,
    user_id: form.user_id ? parseInt(form.user_id) : undefined
  }
  
  if (editingTodo.value) {
    router.put(`/todos/${editingTodo.value.id}`, formData, {
      onSuccess: () => {
        cancelForm()
        processing.value = false
      },
      onError: () => {
        processing.value = false
      },
    })
  } else {
    router.post('/todos', formData, {
      onSuccess: () => {
        cancelForm()
        processing.value = false
      },
      onError: () => {
        processing.value = false
      },
    })
  }
}

const toggleComplete = (todo: Todo) => {
  router.patch(`/todos/${todo.id}/toggle-complete`, {}, {
    preserveScroll: true,
  })
}

const deleteTodo = (todo: Todo) => {
  if (confirm('Are you sure you want to delete this todo?')) {
    router.delete(`/todos/${todo.id}`, {
      preserveScroll: true,
    })
  }
}

const applyFilters = () => {
  const params: Record<string, string> = {}
  
  if (selectedStatus.value) {
    params.status = selectedStatus.value
  }
  
  if (selectedUserId.value) {
    params.user_id = selectedUserId.value
  }
  
  router.get('/todos', params, {
    preserveState: true,
    preserveScroll: true,
  })
}

const formatDate = (dateString: string) => {
  if (!dateString) return ''
  return new Date(dateString).toLocaleDateString()
}
</script>
