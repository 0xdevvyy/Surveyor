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
                'relative overflow-hidden rounded-2xl border border-border bg-card p-3 text-card-foreground sm:rounded-[20px] sm:p-5',
                $props.class,
            )
        "
    >
        <div class="absolute inset-y-0 left-0 w-[2px] bg-ring" />

        <div class="flex items-start justify-between gap-3">
            <div class="flex items-center gap-3">
                <div
                    class="flex size-9 items-center justify-center rounded-lg border border-border bg-accent sm:size-12 sm:rounded-xl"
                >
                    <slot name="icon" />
                </div>
            </div>
        </div>

        <div class="mt-4 space-y-2 sm:mt-8">
            <h2
                class="text-sm font-medium leading-tight text-card-foreground sm:text-[1.15rem]"
            >
                {{ label }}
            </h2>

            <div class="flex items-end justify-between gap-3">
                <p
                    class="text-3xl font-light leading-none tracking-[-0.08em] text-card-foreground sm:text-[3.1rem]"
                >
                    {{ value }}
                </p>
                <span
                    v-if="change"
                    :class="
                        cn(
                            'text-xs font-medium',
                            trend === 'up' && 'text-chart-2',
                            trend === 'down' && 'text-destructive',
                            trend === 'neutral' && 'text-muted-foreground',
                        )
                    "
                >
                    {{ change }}
                </span>
            </div>
        </div>

        <p
            v-if="changeLabel"
            class="mt-3 hidden text-xs text-muted-foreground sm:block"
        >
            {{ changeLabel }}
        </p>
    </section>
</template>
