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
          class="inline-flex items-center justify-center whitespace-nowrap rounded-lg text-base font-bold
          shadow-[4px_4px_0_0_#000] border-2 border-black text-black
          hover:bg-green-400 active:shadow-[2px_2px_0_0_#000] transition-all
          hover:shadow-[1px_1px_0px_0px_rgba(0,0,0,1)] hover:translate-x-[2px] hover:translate-y-[2px] focus:outline-none
          px-6 py-2"
        >
          Add New Todo
        </button>
      </div>

      <!-- Filters -->
      <TodoFilter
        v-model:selected-status="selectedStatus"
        v-model:selected-user-id="selectedUserId"
        :users="users"
        :is-admin="isAdmin"
        @update:selected-status="applyFilters"
        @update:selected-user-id="applyFilters"
      />

      <!-- Todo List -->
      <TodoList
        :todos="todos"
        :is-admin="isAdmin"
        @toggle-complete="toggleComplete"
        @edit="editTodo"
        @delete="deleteTodo"
      />

      <!-- Create/Edit Modal -->
      <TodoModal
        :is-visible="showCreateForm || !!editingTodo"
        :editing-todo="editingTodo"
        :users="users"
        :is-admin="isAdmin"
        :processing="processing"
        @submit="submitForm"
        @cancel="cancelForm"
      />
    </div>
  </AppLayout>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { router, Head } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'
import TodoFilter from '../../components/Todos/TodoFilter.vue'
import TodoList from '../../components/Todos/TodoList.vue'
import TodoModal from '../../components/Todos/TodoModal.vue'
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

const editTodo = (todo: Todo) => {
  editingTodo.value = todo
}

const cancelForm = () => {
  showCreateForm.value = false
  editingTodo.value = null
}

const submitForm = (formData: any) => {
  processing.value = true
  
  const data = {
    ...formData,
    user_id: formData.user_id ? parseInt(formData.user_id) : undefined
  }
  
  if (editingTodo.value) {
    router.put(`/todos/${editingTodo.value.id}`, data, {
      onSuccess: () => {
        cancelForm()
        processing.value = false
      },
      onError: () => {
        processing.value = false
      },
    })
  } else {
    router.post('/todos', data, {
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
</script>