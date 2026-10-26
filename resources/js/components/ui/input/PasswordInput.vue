<script setup lang="ts">
import { ref } from "vue";
import { cn } from "@/lib/utils";
import { Eye, EyeOff } from "@lucide/vue";

defineOptions({ inheritAttrs: false });

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
            v-bind="$attrs"
            v-model="model"
            :type="isVisible ? 'text' : 'password'"
            :placeholder="placeholder"
            :disabled="disabled"
            :class="
                cn(
                    'flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 pr-10 text-sm text-foreground shadow-sm placeholder:text-muted-foreground focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 focus-visible:outline-none disabled:cursor-not-allowed disabled:opacity-50',
                    $props.class,
                )
            "
        />
        <button
            type="button"
            :disabled="disabled"
            :aria-label="isVisible ? 'Hide password' : 'Show password'"
            :aria-pressed="isVisible"
            class="absolute top-1/2 right-2 -translate-y-1/2 rounded p-1 text-muted-foreground hover:text-foreground focus-visible:ring-2 focus-visible:ring-ring focus-visible:outline-none disabled:opacity-50"
            @click="isVisible = !isVisible"
        >
            <EyeOff v-if="isVisible" aria-hidden="true" class="size-4" />
            <Eye v-else aria-hidden="true" class="size-4" />
        </button>
    </div>
</template>
