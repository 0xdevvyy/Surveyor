<script setup lang="ts">
import { cn } from "@/lib/utils";

withDefaults(
    defineProps<{
        disabled?: boolean;
        class?: string;
    }>(),
    {
        disabled: false,
        class: "",
    },
);

const model = defineModel<string | number>();
</script>

<template>
    <select
        v-model="model"
        :disabled="disabled"
        :class="
            cn(
                'flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm text-foreground shadow-sm transition-colors focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 focus-visible:outline-none disabled:cursor-not-allowed disabled:opacity-50',
                $props.class,
            )
        "
    >
        <slot />
    </select>
</template>
