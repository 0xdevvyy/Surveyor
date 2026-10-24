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
    <header :class="cn('grid gap-1.5 pr-8 text-left', $props.class)">
        <slot />
    </header>
</template>
