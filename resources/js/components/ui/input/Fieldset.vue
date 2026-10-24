<script setup lang="ts">
import { cn } from "@/lib/utils";

withDefaults(
    defineProps<{
        legend?: string;
        description?: string;
        disabled?: boolean;
        class?: string;
    }>(),
    {
        legend: "",
        description: "",
        disabled: false,
        class: "",
    },
);
</script>

<template>
    <fieldset
        :disabled="disabled"
        :class="cn('grid gap-4 disabled:opacity-70', $props.class)"
    >
        <legend v-if="legend" class="text-base font-semibold">
            {{ legend }}
        </legend>
        <p v-if="description" class="text-sm text-muted-foreground">
            {{ description }}
        </p>
        <slot />
    </fieldset>
</template>
