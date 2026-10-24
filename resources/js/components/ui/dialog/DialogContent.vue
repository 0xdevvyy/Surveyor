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
    <div :class="cn('grid gap-4 pt-2', $props.class)">
        <slot />
    </div>
</template>
