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
        role="switch"
        :aria-label="label"
        :aria-checked="model"
        :disabled="disabled"
        :class="
            cn(
                'inline-flex h-6 w-11 shrink-0 cursor-pointer items-center rounded-full border-2 border-transparent bg-input transition-colors focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 focus-visible:outline-none disabled:cursor-not-allowed disabled:opacity-50',
                model && 'bg-primary',
                $props.class,
            )
        "
        @click="model = !model"
    >
        <span
            :class="
                cn(
                    'pointer-events-none block size-5 rounded-full bg-background shadow-sm transition-transform',
                    model && 'translate-x-5',
                )
            "
        />
    </button>
</template>
