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
    <thead :class="cn('[&_tr]:border-b [&_tr]:border-border', $props.class)">
        <slot />
    </thead>
</template>
