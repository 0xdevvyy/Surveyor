<script setup lang="ts">
import { cn } from "@/lib/utils";

withDefaults(
    defineProps<{
        size?: "default" | "wide" | "full";
        class?: string;
    }>(),
    {
        size: "default",
        class: "",
    },
);

const sizes = {
    default: "max-w-7xl",
    wide: "max-w-screen-2xl",
    full: "max-w-none",
};
</script>

<template>
    <div
        :class="
            cn(
                'mx-auto w-full px-4 py-6 sm:px-6 lg:px-8',
                sizes[size],
                $props.class,
            )
        "
    >
        <slot />
    </div>
</template>
