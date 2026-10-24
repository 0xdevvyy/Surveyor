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
</script>

<template>
    <label
        :class="
            cn(
                'text-sm leading-none font-medium peer-disabled:cursor-not-allowed peer-disabled:opacity-70',
                disabled && 'cursor-not-allowed opacity-70',
                $props.class,
            )
        "
    >
        <slot />
    </label>
</template>
