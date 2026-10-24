<script setup lang="ts">
import { cn } from "@/lib/utils";

withDefaults(
    defineProps<{
        class?: string;
    }>(),
    {
        class: "",
    },
);
</script>

<template>
    <footer
        :class="
            cn(
                'flex flex-col gap-2 border-t border-border px-4 py-4 text-sm text-muted-foreground sm:flex-row sm:items-center sm:justify-between sm:px-6',
                $props.class,
            )
        "
    >
        <slot />
    </footer>
</template>
