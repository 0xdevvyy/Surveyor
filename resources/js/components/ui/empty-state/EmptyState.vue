<script setup lang="ts">
import { cn } from "@/lib/utils";

withDefaults(
    defineProps<{
        title: string;
        description?: string;
        class?: string;
    }>(),
    {
        description: "",
        class: "",
    },
);
</script>

<template>
    <section
        role="status"
        :class="
            cn(
                'flex min-h-48 flex-col items-center justify-center gap-3 rounded-lg border border-dashed border-border p-8 text-center',
                $props.class,
            )
        "
    >
        <div
            v-if="$slots.icon"
            class="flex size-10 items-center justify-center rounded-full bg-muted text-muted-foreground"
        >
            <slot name="icon" />
        </div>
        <div class="grid gap-1">
            <h2 class="font-medium">{{ title }}</h2>
            <p
                v-if="description"
                class="max-w-md text-sm text-muted-foreground"
            >
                {{ description }}
            </p>
        </div>
        <slot />
    </section>
</template>
