<script setup lang="ts">
import { cn } from "@/lib/utils";

withDefaults(
    defineProps<{
        disabled?: boolean;
        rows?: number;
        class?: string;
    }>(),
    {
        disabled: false,
        rows: 4,
        class: "",
    },
);

const model = defineModel<string>();
</script>

<template>
    <textarea
        v-model="model"
        :rows="rows"
        :disabled="disabled"
        :class="
            cn(
                'flex min-h-20 w-full rounded-md border border-input bg-background px-3 py-2 text-sm text-foreground shadow-sm transition-colors placeholder:text-muted-foreground focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 focus-visible:outline-none disabled:cursor-not-allowed disabled:opacity-50',
                $props.class,
            )
        "
    />
</template>
