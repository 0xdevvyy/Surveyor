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
    <footer
        :class="
            cn(
                'flex flex-col-reverse gap-2 pt-4 sm:flex-row sm:justify-end',
                $props.class,
            )
        "
    >
        <slot />
    </footer>
</template>
