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
    <div :class="cn('w-full divide-y divide-border', $props.class)">
        <slot />
    </div>
</template>
