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
    <td :class="cn('p-4 align-middle', $props.class)">
        <slot />
    </td>
</template>
