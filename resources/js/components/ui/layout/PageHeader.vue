<script setup lang="ts">
import { cn } from "@/lib/utils";

withDefaults(
    defineProps<{
        title?: string;
        description?: string;
        class?: string;
    }>(),
    {
        title: "",
        description: "",
        class: "",
    },
);
</script>

<template>
    <header
        :class="
            cn(
                'flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between',
                $props.class,
            )
        "
    >
        <div class="grid gap-1">
            <slot name="title">
                <h1 v-if="title" class="text-2xl font-semibold tracking-tight">
                    {{ title }}
                </h1>
            </slot>
            <slot name="description">
                <p v-if="description" class="text-sm text-muted-foreground">
                    {{ description }}
                </p>
            </slot>
        </div>
        <div v-if="$slots.actions" class="flex shrink-0 items-center gap-2">
            <slot name="actions" />
        </div>
    </header>
</template>
