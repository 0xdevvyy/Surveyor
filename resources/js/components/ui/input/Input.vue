<script setup lang="ts">
import { cn } from "@/lib/utils";

withDefaults(
    defineProps<{
        type?: string;
        disabled?: boolean;
        class?: string;
    }>(),
    {
        type: "text",
        disabled: false,
        class: "",
    },
);

const model = defineModel<string | number>();
</script>

<template>
    <input
        v-model="model"
        :type="type"
        :disabled="disabled"
        :class="
            cn(
                'flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm text-foreground shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 focus-visible:outline-none disabled:cursor-not-allowed disabled:opacity-50',
                $props.class,
            )
        "
    />
</template>
