import { type VariantProps, cva } from 'class-variance-authority'
export { default as Button } from './Button.vue'

export const buttonVariants = cva(
  // Base styles with neobrutalism characteristics
  'inline-flex items-center justify-center whitespace-nowrap rounded-none border-2 border-black font-bold text-sm transition-all duration-150 ease-out transform active:translate-x-[2px] active:translate-y-[2px] active:shadow-none disabled:pointer-events-none disabled:opacity-50 uppercase tracking-wider',
  {
    variants: {
      variant: {
        // Primary - Bold with thick shadow
        default: 'bg-yellow-400 text-black border-black shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:shadow-[6px_6px_0px_0px_rgba(0,0,0,1)] hover:translate-x-[-2px] hover:translate-y-[-2px]',
        
        // Destructive - Red with bold shadow
        destructive: 'bg-red-500 text-white border-black shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:shadow-[6px_6px_0px_0px_rgba(0,0,0,1)] hover:translate-x-[-2px] hover:translate-y-[-2px]',
        
        // Outline - White background with bold border
        outline: 'bg-white text-black border-black shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:shadow-[6px_6px_0px_0px_rgba(0,0,0,1)] hover:translate-x-[-2px] hover:translate-y-[-2px]',
        
        // Secondary - Blue with bold styling
        secondary: 'bg-blue-400 text-black border-black shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:shadow-[6px_6px_0px_0px_rgba(0,0,0,1)] hover:translate-x-[-2px] hover:translate-y-[-2px]',
        
        // Ghost - Minimal with hover effects
        ghost: 'bg-transparent text-black border-black hover:bg-gray-100 shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] hover:shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:translate-x-[-2px] hover:translate-y-[-2px]',
        
        // Link - Text only with underline effect
        link: 'bg-transparent text-black border-none shadow-none underline-offset-4 hover:underline decoration-2 decoration-black',
        
        // Success - Green variant
        success: 'bg-green-400 text-black border-black shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:shadow-[6px_6px_0px_0px_rgba(0,0,0,1)] hover:translate-x-[-2px] hover:translate-y-[-2px]',
        
        // Warning - Orange variant  
        warning: 'bg-orange-400 text-black border-black shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:shadow-[6px_6px_0px_0px_rgba(0,0,0,1)] hover:translate-x-[-2px] hover:translate-y-[-2px]',
      },
      size: {
        default: 'h-12 px-6 py-3',
        sm: 'h-10 px-4 py-2 text-xs',
        lg: 'h-14 px-8 py-4 text-base',
        xl: 'h-16 px-10 py-5 text-lg',
        icon: 'h-12 w-12',
      },
    },
    defaultVariants: {
      variant: 'default',
      size: 'default',
    },
  }
)

export type ButtonVariants = VariantProps<typeof buttonVariants>
