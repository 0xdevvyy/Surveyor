<script setup lang="ts">
import { cn } from "@/lib/utils";

withDefaults(
    defineProps<{
        title?: string;
        description?: string;
        class?: string;
    }>(),
    {
        title: "Something went wrong",
        description:
            "Please try again. If the problem continues, contact support.",
        class: "",
    },
);
</script>

<template>
    <section
        role="alert"
        :class="
            cn(
                'flex flex-col items-center justify-center gap-3 rounded-lg border border-destructive/30 bg-destructive/5 p-8 text-center',
                $props.class,
            )
        "
    >
        <div class="grid gap-1">
            <h2 class="font-semibold text-destructive">{{ title }}</h2>
            <p class="max-w-md text-sm text-muted-foreground">
                {{ description }}
            </p>
        </div>
        <slot />
    </section>
</template>
