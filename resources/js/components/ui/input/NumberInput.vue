<script setup lang="ts">
import { cn } from "@/lib/utils";

withDefaults(
    defineProps<{
        min?: number;
        max?: number;
        step?: number;
        disabled?: boolean;
        class?: string;
    }>(),
    {
        min: undefined,
        max: undefined,
        step: 1,
        disabled: false,
        class: "",
    },
);

const model = defineModel<number | undefined>();
</script>

<template>
    <input
        v-model.number="model"
        type="number"
        :min="min"
        :max="max"
        :step="step"
        :disabled="disabled"
        :class="
            cn(
                'flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm text-foreground shadow-sm focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 focus-visible:outline-none disabled:cursor-not-allowed disabled:opacity-50',
                $props.class,
            )
        "
    />
</template>
