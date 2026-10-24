<script setup lang="ts">
import { computed } from "vue";
import { cn } from "@/lib/utils";

const props = withDefaults(
    defineProps<{
        value: number;
        max?: number;
        label?: string;
        class?: string;
    }>(),
    {
        max: 100,
        label: "Progress",
        class: "",
    },
);

const percentage = computed(() => {
    if (props.max <= 0) {
        return 0;
    }

    return Math.min(100, Math.max(0, (props.value / props.max) * 100));
});
</script>

<template>
    <div
        role="progressbar"
        :aria-label="label"
        :aria-valuenow="Math.min(max, Math.max(0, value))"
        :aria-valuemin="0"
        :aria-valuemax="max"
        :class="
            cn(
                'h-2 w-full overflow-hidden rounded-full bg-secondary',
                $props.class,
            )
        "
    >
        <div
            class="h-full rounded-full bg-primary transition-[width]"
            :style="{ width: `${percentage}%` }"
        />
    </div>
</template>
