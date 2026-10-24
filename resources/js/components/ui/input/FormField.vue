<script setup lang="ts">
import { useId } from "vue";
import { cn } from "@/lib/utils";

withDefaults(
    defineProps<{
        label?: string;
        description?: string;
        error?: string;
        required?: boolean;
        class?: string;
    }>(),
    {
        label: "",
        description: "",
        error: "",
        required: false,
        class: "",
    },
);

const fieldId = useId();
</script>

<template>
    <div :class="cn('grid gap-2', $props.class)">
        <label
            v-if="label"
            :for="fieldId"
            class="text-sm leading-none font-medium"
        >
            {{ label }}
            <span v-if="required" aria-hidden="true" class="text-destructive">
                *
            </span>
        </label>
        <slot :id="fieldId" />
        <p
            v-if="description && !error"
            :id="`${fieldId}-description`"
            class="text-sm text-muted-foreground"
        >
            {{ description }}
        </p>
        <p
            v-if="error"
            :id="`${fieldId}-error`"
            role="alert"
            class="text-sm font-medium text-destructive"
        >
            {{ error }}
        </p>
    </div>
</template>
