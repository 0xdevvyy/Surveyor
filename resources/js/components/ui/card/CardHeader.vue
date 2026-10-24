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
    <header :class="cn('flex flex-col gap-1.5 p-6', $props.class)">
        <slot />
    </header>
</template>
