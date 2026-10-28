<script setup lang="ts">
import type { ClassValue } from "clsx";
import { ref } from "vue";
import { cn } from "@/lib/utils";

const props = withDefaults(
    defineProps<{
        text: string;
        side?: "top" | "bottom" | "right";
        portal?: boolean;
        triggerClass?: string;
        class?: ClassValue;
    }>(),
    {
        side: "top",
        portal: false,
        triggerClass: "",
        class: "",
    },
);

const trigger = ref<HTMLElement | null>(null);
const isVisible = ref(false);
const position = ref({ left: 0, top: 0 });

function showTooltip() {
    if (props.portal) {
        const bounds = trigger.value?.getBoundingClientRect();

        if (!bounds) {
            return;
        }

        position.value = {
            left: bounds.right + 8,
            top: bounds.top + bounds.height / 2,
        };
        isVisible.value = true;
    }
}

function hideTooltip() {
    isVisible.value = false;
}
</script>

<template>
    <span
        ref="trigger"
        :class="cn('group/tooltip relative inline-flex', triggerClass)"
        @mouseenter="showTooltip"
        @mouseleave="hideTooltip"
        @focusin="showTooltip"
        @focusout="hideTooltip"
    >
        <slot />
        <Teleport v-if="portal && isVisible" to="body">
            <span
                role="tooltip"
                :class="
                    cn(
                        'pointer-events-none fixed z-[100] w-max max-w-64 -translate-y-1/2 rounded-md bg-popover px-2.5 py-1.5 text-xs text-popover-foreground shadow-md ring-1 ring-border',
                        $props.class,
                    )
                "
                :style="{
                    left: `${position.left}px`,
                    top: `${position.top}px`,
                }"
            >
                {{ text }}
            </span>
        </Teleport>
        <span
            v-if="!portal"
            role="tooltip"
            :class="
                cn(
                    'pointer-events-none absolute left-1/2 z-50 w-max max-w-64 -translate-x-1/2 rounded-md bg-popover px-2.5 py-1.5 text-xs text-popover-foreground opacity-0 shadow-md ring-1 ring-border transition-opacity group-hover/tooltip:opacity-100 group-focus-within/tooltip:opacity-100',
                    side === 'top' ? 'bottom-full mb-2' : 'top-full mt-2',
                    $props.class,
                )
            "
        >
            {{ text }}
        </span>
    </span>
</template>
