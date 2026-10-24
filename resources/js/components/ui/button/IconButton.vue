<script setup lang="ts">
import { cn } from "@/lib/utils";

withDefaults(
    defineProps<{
        label: string;
        variant?: "default" | "outline" | "ghost" | "destructive";
        disabled?: boolean;
        type?: "button" | "submit" | "reset";
        class?: string;
    }>(),
    {
        variant: "ghost",
        disabled: false,
        type: "button",
        class: "",
    },
);

const variants = {
    default: "bg-primary text-primary-foreground hover:bg-primary/90",
    outline:
        "border border-input bg-background hover:bg-accent hover:text-accent-foreground",
    ghost: "hover:bg-accent hover:text-accent-foreground",
    destructive:
        "bg-destructive text-destructive-foreground hover:bg-destructive/90",
};
</script>

<template>
    <button
        :type="type"
        :aria-label="label"
        :title="label"
        :disabled="disabled"
        :class="
            cn(
                'inline-flex size-10 shrink-0 items-center justify-center rounded-md transition-colors focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 focus-visible:outline-none disabled:pointer-events-none disabled:opacity-50',
                variants[variant],
                $props.class,
            )
        "
    >
        <slot />
    </button>
</template>
