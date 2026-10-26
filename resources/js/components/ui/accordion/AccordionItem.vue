<script setup lang="ts">
import { cn } from "@/lib/utils";
import { ChevronDown } from "@lucide/vue";

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
            <ChevronDown
                aria-hidden="true"
                class="size-4 shrink-0 text-muted-foreground transition-transform group-open:rotate-180"
            />
        </summary>
        <div class="pt-3 text-sm text-muted-foreground">
            <slot />
        </div>
    </details>
</template>
