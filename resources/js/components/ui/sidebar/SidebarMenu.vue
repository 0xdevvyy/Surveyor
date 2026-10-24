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
    <ul :class="cn('flex flex-col gap-1', $props.class)">
        <slot />
    </ul>
</template>
