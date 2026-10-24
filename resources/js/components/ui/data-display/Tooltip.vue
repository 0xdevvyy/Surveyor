<script setup lang="ts">
import { cn } from "@/lib/utils";

withDefaults(
    defineProps<{
        text: string;
        side?: "top" | "bottom";
        class?: string;
    }>(),
    {
        side: "top",
        class: "",
    },
);
</script>

<template>
    <span class="group/tooltip relative inline-flex">
        <slot />
        <span
            role="tooltip"
            :class="
                cn(
                    'pointer-events-none absolute left-1/2 z-50 w-max max-w-64 -translate-x-1/2 rounded-md bg-popover px-2.5 py-1.5 text-xs text-popover-foreground opacity-0 shadow-md ring-1 ring-border transition-opacity group-hover/tooltip:opacity-100 group-focus-within/tooltip:opacity-100',
                    side === 'top' ? 'bottom-full mb-2' : 'top-full mt-2',
                    $props.class,
                )
            "
        >
            {{ text }}
        </span>
    </span>
</template>
