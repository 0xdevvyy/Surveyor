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
    <div
        aria-hidden="true"
        :class="cn('animate-pulse rounded-md bg-muted', $props.class)"
    />
</template>
