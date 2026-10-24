<script setup lang="ts">
import { cn } from "@/lib/utils";

withDefaults(
    defineProps<{
        variant?: "default" | "secondary" | "outline" | "ghost" | "destructive";
        size?: "default" | "sm" | "lg" | "icon";
        type?: "button" | "submit" | "reset";
        disabled?: boolean;
    }>(),
    {
        variant: "default",
        size: "default",
        type: "button",
        disabled: false,
    },
);

const variants = {
    default: "bg-primary text-primary-foreground hover:bg-primary-hover",
    secondary: "bg-secondary text-secondary-foreground hover:bg-secondary/80",
    outline:
        "border border-input bg-background hover:bg-accent hover:text-accent-foreground",
    ghost: "hover:bg-accent hover:text-accent-foreground",
    destructive:
        "bg-destructive text-destructive-foreground hover:bg-destructive/90",
};

const sizes = {
    default: "h-10 px-4 py-2",
    sm: "h-9 rounded-md px-3",
    lg: "h-11 rounded-md px-8",
    icon: "size-10",
};
</script>

<template>
    <button
        :type="type"
        :disabled="disabled"
        :class="
            cn(
                'inline-flex shrink-0 items-center justify-center gap-2 rounded-md text-sm font-medium whitespace-nowrap transition-colors focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 focus-visible:outline-none disabled:pointer-events-none disabled:opacity-50',
                variants[variant],
                sizes[size],
            )
        "
    >
        <slot />
    </button>
</template>
