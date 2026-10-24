<script setup lang="ts">
import { cn } from "@/lib/utils";

withDefaults(
    defineProps<{
        label: string;
        value: string | number;
        change?: string;
        changeLabel?: string;
        trend?: "up" | "down" | "neutral";
        class?: string;
    }>(),
    {
        change: "",
        changeLabel: "",
        trend: "neutral",
        class: "",
    },
);
</script>

<template>
    <section
        :class="
            cn(
                'grid gap-3 rounded-xl border border-border bg-card p-5 text-card-foreground shadow-sm',
                $props.class,
            )
        "
    >
        <div class="flex items-center justify-between gap-3">
            <h2 class="text-sm font-medium text-muted-foreground">
                {{ label }}
            </h2>
            <slot name="icon" />
        </div>
        <div class="flex items-baseline justify-between gap-3">
            <p class="text-2xl font-semibold tracking-tight">{{ value }}</p>
            <span
                v-if="change"
                :class="
                    cn(
                        'text-xs font-medium',
                        trend === 'up' && 'text-success',
                        trend === 'down' && 'text-destructive',
                        trend === 'neutral' && 'text-muted-foreground',
                    )
                "
            >
                {{ change }}
            </span>
        </div>
        <p v-if="changeLabel" class="text-xs text-muted-foreground">
            {{ changeLabel }}
        </p>
    </section>
</template>
