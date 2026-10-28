<script setup lang="ts">
import type { ClassValue } from "clsx";
import { cn } from "@/lib/utils";

withDefaults(
    defineProps<{
        label?: string;
        class?: ClassValue;
    }>(),
    {
        label: "",
        class: "",
    },
);
</script>

<template>
    <section :class="cn('grid gap-1', $props.class)">
        <h2
            v-if="label || $slots.label"
            class="px-3 py-2 text-xs font-semibold tracking-wider text-sidebar-foreground/70 uppercase"
        >
            <slot name="label">{{ label }}</slot>
        </h2>
        <slot />
    </section>
</template>
