<script setup lang="ts">
import { cn } from "@/lib/utils";

withDefaults(
    defineProps<{
        disabled?: boolean;
        class?: string;
    }>(),
    {
        disabled: false,
        class: "",
    },
);

const model = defineModel<boolean>({ default: false });
</script>

<template>
    <input
        v-model="model"
        type="checkbox"
        :disabled="disabled"
        :class="
            cn(
                'size-4 shrink-0 rounded-sm border border-primary accent-primary cursor-pointer focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 focus-visible:outline-none disabled:cursor-not-allowed disabled:opacity-50',
                $props.class,
            )
        "
    />
</template>
