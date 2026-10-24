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
    <h2
        :class="
            cn('mb-1 font-semibold leading-none tracking-tight', $props.class)
        "
    >
        <slot />
    </h2>
</template>
