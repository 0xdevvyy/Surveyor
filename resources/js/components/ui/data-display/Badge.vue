<script setup lang="ts">
import { cn } from "@/lib/utils";

withDefaults(
    defineProps<{
        variant?:
            | "default"
            | "secondary"
            | "outline"
            | "destructive"
            | "success"
            | "warning"
            | "info";
        class?: string;
    }>(),
    {
        variant: "default",
        class: "",
    },
);

const variants = {
    default: "border-transparent bg-primary text-primary-foreground",
    secondary: "border-transparent bg-secondary text-secondary-foreground",
    outline: "border-border text-foreground",
    destructive:
        "border-transparent bg-destructive text-destructive-foreground",
    success: "border-transparent bg-success text-success-foreground",
    warning: "border-transparent bg-warning text-warning-foreground",
    info: "border-transparent bg-info text-info-foreground",
};
</script>

<template>
    <span
        :class="
            cn(
                'inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors',
                variants[variant],
                $props.class,
            )
        "
    >
        <slot />
    </span>
</template>
