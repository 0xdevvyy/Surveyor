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
    <footer :class="cn('flex items-center gap-2 p-6 pt-0', $props.class)">
        <slot />
    </footer>
</template>
