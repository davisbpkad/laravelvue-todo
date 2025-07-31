<script setup lang="ts">
import type { HTMLAttributes } from 'vue'
import { cn } from '@/lib/utils'
import { Primitive, type PrimitiveProps } from 'reka-ui'
import { type ButtonVariants, buttonVariants } from '.'

interface Props extends PrimitiveProps {
  variant?: ButtonVariants['variant']
  size?: ButtonVariants['size']
  class?: HTMLAttributes['class']
  disabled?: boolean
  loading?: boolean
}

const props = withDefaults(defineProps<Props>(), {
  as: 'button',
  disabled: false,
  loading: false,
})
</script>

<template>
  <Primitive
    data-slot="button"
    :as="as"
    :as-child="asChild"
    :disabled="disabled || loading"
    :class="cn(
      buttonVariants({ variant, size }), 
      // Additional neobrutalism styles
      'relative overflow-hidden',
      // Loading state
      loading && 'pointer-events-none',
      // Disabled state
      (disabled || loading) && 'opacity-50 cursor-not-allowed transform-none shadow-[2px_2px_0px_0px_rgba(0,0,0,0.3)]',
      props.class
    )"
  >
    <!-- Loading spinner -->
    <div 
      v-if="loading" 
      class="absolute inset-0 flex items-center justify-center bg-inherit"
    >
      <div class="w-4 h-4 border-2 border-current border-t-transparent rounded-full animate-spin"></div>
    </div>
    
    <!-- Button content -->
    <span :class="{ 'opacity-0': loading }">
      <slot />
    </span>
    
    <!-- Neobrutalism accent lines (optional decorative element) -->
    <div 
      v-if="variant !== 'link' && variant !== 'ghost'" 
      class="absolute top-1 left-1 w-2 h-2 bg-black opacity-20 pointer-events-none"
    ></div>
  </Primitive>
</template>
