<script setup lang="ts">
import { cn } from "@/lib/utils";

withDefaults(
    defineProps<{
        side?: "left" | "right";
        class?: string;
    }>(),
    {
        side: "left",
        class: "",
    },
);
</script>

<template>
    <aside
        :class="
            cn(
                'flex h-full w-64 shrink-0 flex-col bg-sidebar text-sidebar-foreground',
                side === 'left' ? 'border-r' : 'border-l',
                'border-sidebar-border',
                $props.class,
            )
        "
    >
        <slot />
    </aside>
</template>
