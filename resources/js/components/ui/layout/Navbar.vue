<script setup lang="ts">
import { cn } from "@/lib/utils";

withDefaults(
    defineProps<{
        sticky?: boolean;
        class?: string;
    }>(),
    {
        sticky: false,
        class: "",
    },
);
</script>

<template>
    <header
        :class="
            cn(
                'flex min-h-14 items-center justify-between gap-4 border-b border-border bg-background px-4 sm:px-6',
                sticky && 'sticky top-0 z-40',
                $props.class,
            )
        "
    >
        <slot />
    </header>
</template>
