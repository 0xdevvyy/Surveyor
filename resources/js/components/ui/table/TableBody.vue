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
    <tbody :class="cn('[&_tr:last-child]:border-0', $props.class)">
        <slot />
    </tbody>
</template>
