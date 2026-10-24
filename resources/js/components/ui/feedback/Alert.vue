<script setup lang="ts">
import { cn } from "@/lib/utils";

withDefaults(
    defineProps<{
        variant?: "default" | "destructive" | "success" | "warning" | "info";
        role?: "alert" | "status";
        class?: string;
    }>(),
    {
        variant: "default",
        role: "status",
        class: "",
    },
);

const variants = {
    default: "border-border bg-card text-card-foreground",
    destructive: "border-destructive/30 bg-destructive/10 text-destructive",
    success: "border-success/30 bg-success/10 text-success",
    warning: "border-warning/30 bg-warning/10 text-warning",
    info: "border-info/30 bg-info/10 text-info",
};
</script>

<template>
    <div
        :role="role"
        :class="
            cn(
                'relative w-full rounded-lg border p-4',
                variants[variant],
                $props.class,
            )
        "
    >
        <slot />
    </div>
</template>
