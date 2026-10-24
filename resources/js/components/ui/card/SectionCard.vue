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
    <section
        :class="
            cn(
                'overflow-hidden rounded-xl border border-border bg-card text-card-foreground shadow-sm',
                $props.class,
            )
        "
    >
        <header
            v-if="title || description || $slots.header || $slots.actions"
            class="flex flex-col gap-3 border-b border-border p-5 sm:flex-row sm:items-start sm:justify-between"
        >
            <div class="grid gap-1">
                <slot name="header">
                    <h2 v-if="title" class="font-semibold">{{ title }}</h2>
                    <p v-if="description" class="text-sm text-muted-foreground">
                        {{ description }}
                    </p>
                </slot>
            </div>
            <slot name="actions" />
        </header>
        <div class="p-5">
            <slot />
        </div>
        <footer v-if="$slots.footer" class="border-t border-border p-5">
            <slot name="footer" />
        </footer>
    </section>
</template>
