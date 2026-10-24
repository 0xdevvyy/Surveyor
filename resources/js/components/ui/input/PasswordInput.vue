<script setup lang="ts">
import { ref } from "vue";
import { cn } from "@/lib/utils";

withDefaults(
    defineProps<{
        placeholder?: string;
        disabled?: boolean;
        class?: string;
    }>(),
    {
        placeholder: "",
        disabled: false,
        class: "",
    },
);

const model = defineModel<string>();
const isVisible = ref(false);
</script>

<template>
    <div class="relative">
        <input
            v-model="model"
            :type="isVisible ? 'text' : 'password'"
            :placeholder="placeholder"
            :disabled="disabled"
            :class="
                cn(
                    'flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 pr-16 text-sm text-foreground shadow-sm placeholder:text-muted-foreground focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 focus-visible:outline-none disabled:cursor-not-allowed disabled:opacity-50',
                    $props.class,
                )
            "
        />
        <button
            type="button"
            :disabled="disabled"
            :aria-label="isVisible ? 'Hide password' : 'Show password'"
            :aria-pressed="isVisible"
            class="absolute top-1/2 right-2 -translate-y-1/2 rounded px-2 py-1 text-xs font-medium text-muted-foreground hover:text-foreground focus-visible:ring-2 focus-visible:ring-ring focus-visible:outline-none disabled:opacity-50"
            @click="isVisible = !isVisible"
        >
            {{ isVisible ? "Hide" : "Show" }}
        </button>
    </div>
</template>
