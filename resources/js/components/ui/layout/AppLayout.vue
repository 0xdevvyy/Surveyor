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
    <div :class="cn('flex min-h-screen flex-col bg-background', $props.class)">
        <slot name="navbar" />
        <div class="flex min-h-0 flex-1">
            <slot name="sidebar" />
            <main class="min-w-0 flex-1">
                <slot />
            </main>
        </div>
        <slot name="footer" />
    </div>
</template>
