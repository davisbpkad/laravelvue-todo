<template>
  <div class="rounded-xl border border-sidebar-border/70 p-4 dark:border-sidebar-border">
    <h2 class="text-lg font-medium text-foreground mb-4">Filters</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <!-- Status Filter -->
      <div>
        <label class="block text-sm font-medium text-foreground mb-2">Filter by Status</label>
        <select
          :value="selectedStatus"
          @change="$emit('update:selectedStatus', ($event.target as HTMLSelectElement)?.value)"
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
          :value="selectedUserId"
          @change="$emit('update:selectedUserId', ($event.target as HTMLSelectElement)?.value)"
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
</template>

<script setup lang="ts">
interface User {
  id: number
  name: string
}

interface Props {
  selectedStatus: string
  selectedUserId: string
  users: User[]
  isAdmin: boolean
}

defineProps<Props>()
defineEmits<{
  'update:selectedStatus': [value: string]
  'update:selectedUserId': [value: string]
}>()
</script>