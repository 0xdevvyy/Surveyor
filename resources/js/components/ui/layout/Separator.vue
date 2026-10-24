<script setup lang="ts">
import { cn } from "@/lib/utils";

withDefaults(
    defineProps<{
        orientation?: "horizontal" | "vertical";
        decorative?: boolean;
        class?: string;
    }>(),
    {
        orientation: "horizontal",
        decorative: true,
        class: "",
    },
);
</script>

<template>
    <div
        :role="decorative ? 'none' : 'separator'"
        :aria-orientation="decorative ? undefined : orientation"
        :class="
            cn(
                'shrink-0 bg-border',
                orientation === 'horizontal' ? 'h-px w-full' : 'h-full w-px',
                $props.class,
            )
        "
    />
</template>
