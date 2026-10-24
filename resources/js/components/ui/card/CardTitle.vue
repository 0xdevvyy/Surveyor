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
    <h2
        :class="
            cn(
                'text-lg leading-none font-semibold tracking-tight',
                $props.class,
            )
        "
    >
        <slot />
    </h2>
</template>
