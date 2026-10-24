<script setup lang="ts">
import { cn } from "@/lib/utils";

withDefaults(
    defineProps<{
        label?: string;
        orientation?: "horizontal" | "vertical";
        class?: string;
    }>(),
    {
        label: undefined,
        orientation: "horizontal",
        class: "",
    },
);
</script>

<template>
    <div
        role="group"
        :aria-label="label"
        :class="
            cn(
                'inline-flex items-center [&>button:not(:first-child)]:rounded-l-none [&>button:not(:last-child)]:rounded-r-none [&>button:not(:last-child)]:border-r-0',
                orientation === 'vertical' &&
                    'flex-col [&>button:not(:first-child)]:rounded-t-none [&>button:not(:first-child)]:rounded-l-md [&>button:not(:last-child)]:rounded-r-md [&>button:not(:last-child)]:rounded-b-none [&>button:not(:last-child)]:border-r [&>button:not(:last-child)]:border-b-0',
                $props.class,
            )
        "
    >
        <slot />
    </div>
</template>
