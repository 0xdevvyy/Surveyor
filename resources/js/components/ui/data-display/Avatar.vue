<script setup lang="ts">
import { computed, ref, watch } from "vue";
import { cn } from "@/lib/utils";

const props = withDefaults(
    defineProps<{
        src?: string;
        alt?: string;
        name?: string;
        class?: string;
    }>(),
    {
        src: "",
        alt: "",
        name: "",
        class: "",
    },
);

const imageFailed = ref(false);
const initials = computed(() => {
    const words = props.name.trim().split(/\s+/).filter(Boolean);

    return words
        .slice(0, 2)
        .map((word) => word.charAt(0))
        .join("")
        .toUpperCase();
});

watch(
    () => props.src,
    () => {
        imageFailed.value = false;
    },
);
</script>

<template>
    <span
        :class="
            cn(
                'relative inline-flex size-10 shrink-0 items-center justify-center overflow-hidden rounded-full bg-muted text-sm font-medium text-muted-foreground',
                $props.class,
            )
        "
    >
        <img
            v-if="src && !imageFailed"
            :src="src"
            :alt="alt || name"
            class="size-full object-cover"
            @error="imageFailed = true"
        />
        <span v-else aria-hidden="true">{{ initials || "?" }}</span>
    </span>
</template>
