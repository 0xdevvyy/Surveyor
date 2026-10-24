<script setup lang="ts">
import { cn } from "@/lib/utils";

withDefaults(
    defineProps<{
        label?: string;
        orientation?: "vertical" | "horizontal" | "both";
        class?: string;
    }>(),
    {
        label: undefined,
        orientation: "vertical",
        class: "",
    },
);

const overflowClasses = {
    vertical: "overflow-x-hidden overflow-y-auto",
    horizontal: "overflow-x-auto overflow-y-hidden",
    both: "overflow-auto",
};
</script>

<template>
    <div
        :role="label ? 'region' : undefined"
        :aria-label="label"
        :tabindex="label ? 0 : undefined"
        :class="
            cn('overscroll-contain', overflowClasses[orientation], $props.class)
        "
    >
        <slot />
    </div>
</template>
