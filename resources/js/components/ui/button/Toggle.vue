<script setup lang="ts">
import { cn } from "@/lib/utils";

withDefaults(
    defineProps<{
        disabled?: boolean;
        label: string;
        class?: string;
    }>(),
    {
        disabled: false,
        class: "",
    },
);

const model = defineModel<boolean>({ default: false });
</script>

<template>
    <button
        type="button"
        :aria-label="label"
        :aria-pressed="model"
        :disabled="disabled"
        :class="
            cn(
                'inline-flex min-h-9 items-center justify-center rounded-md border border-input px-3 text-sm font-medium transition-colors hover:bg-accent hover:text-accent-foreground focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 focus-visible:outline-none disabled:pointer-events-none disabled:opacity-50',
                model && 'bg-accent text-accent-foreground',
                $props.class,
            )
        "
        @click="model = !model"
    >
        <slot />
    </button>
</template>
