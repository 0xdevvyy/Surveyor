<script setup lang="ts">
import { cn } from "@/lib/utils";

withDefaults(
    defineProps<{
        label?: string;
        size?: "sm" | "default" | "lg";
        class?: string;
    }>(),
    {
        label: "Loading",
        size: "default",
        class: "",
    },
);

const sizes = {
    sm: "size-4 border-2",
    default: "size-6 border-2",
    lg: "size-9 border-[3px]",
};
</script>

<template>
    <span
        role="status"
        :aria-label="label"
        :class="
            cn(
                'inline-block animate-spin rounded-full border-primary/30 border-t-primary motion-reduce:animate-none',
                sizes[size],
                $props.class,
            )
        "
    />
</template>
