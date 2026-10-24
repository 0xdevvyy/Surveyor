<script setup lang="ts">
import { cn } from "@/lib/utils";

withDefaults(
    defineProps<{
        title: string;
        defaultOpen?: boolean;
        class?: string;
    }>(),
    {
        defaultOpen: false,
        class: "",
    },
);
</script>

<template>
    <details :open="defaultOpen" :class="cn('group py-4', $props.class)">
        <summary
            class="flex cursor-pointer list-none items-center justify-between gap-4 font-medium marker:content-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:outline-none [&::-webkit-details-marker]:hidden"
        >
            <slot name="title">{{ title }}</slot>
            <svg
                aria-hidden="true"
                class="size-4 shrink-0 text-muted-foreground transition-transform group-open:rotate-180"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
            >
                <path d="m6 9 6 6 6-6" />
            </svg>
        </summary>
        <div class="pt-3 text-sm text-muted-foreground">
            <slot />
        </div>
    </details>
</template>
