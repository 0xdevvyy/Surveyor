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
    <div
        :class="
            cn('text-sm leading-relaxed [&_p]:leading-relaxed', $props.class)
        "
    >
        <slot />
    </div>
</template>
