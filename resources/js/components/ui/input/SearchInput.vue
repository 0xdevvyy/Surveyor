<script setup lang="ts">
import { cn } from "@/lib/utils";

withDefaults(
    defineProps<{
        placeholder?: string;
        label?: string;
        disabled?: boolean;
        class?: string;
    }>(),
    {
        placeholder: "Search...",
        label: "Search",
        disabled: false,
        class: "",
    },
);

const model = defineModel<string>({ default: "" });
</script>

<template>
    <div class="relative">
        <svg
            aria-hidden="true"
            class="pointer-events-none absolute top-1/2 left-3 size-4 -translate-y-1/2 text-muted-foreground"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
            stroke-linecap="round"
        >
            <circle cx="11" cy="11" r="8" />
            <path d="m21 21-4.35-4.35" />
        </svg>
        <input
            v-model="model"
            type="search"
            :aria-label="label"
            :placeholder="placeholder"
            :disabled="disabled"
            :class="
                cn(
                    'flex h-10 w-full rounded-md border border-input bg-background py-2 pr-3 pl-9 text-sm text-foreground shadow-sm placeholder:text-muted-foreground focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 focus-visible:outline-none disabled:cursor-not-allowed disabled:opacity-50',
                    $props.class,
                )
            "
        />
    </div>
</template>
