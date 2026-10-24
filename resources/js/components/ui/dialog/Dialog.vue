<script setup lang="ts">
import { onMounted, ref, watch } from "vue";
import { cn } from "@/lib/utils";

withDefaults(
    defineProps<{
        label?: string;
        closeLabel?: string;
        class?: string;
    }>(),
    {
        label: "Dialog",
        closeLabel: "Close dialog",
        class: "",
    },
);

const isOpen = defineModel<boolean>({ default: false });
const dialogElement = ref<HTMLDialogElement | null>(null);

function syncDialogState(): void {
    const dialog = dialogElement.value;

    if (!dialog) {
        return;
    }

    if (isOpen.value && !dialog.open) {
        dialog.showModal();
    } else if (!isOpen.value && dialog.open) {
        dialog.close();
    }
}

function closeDialog(): void {
    isOpen.value = false;
}

watch(isOpen, syncDialogState, { flush: "post" });
onMounted(syncDialogState);
</script>

<template>
    <dialog
        ref="dialogElement"
        :aria-label="label"
        :class="
            cn(
                'fixed inset-0 m-auto max-h-[calc(100%-2rem)] w-[calc(100%-2rem)] max-w-lg overflow-y-auto rounded-xl border border-border bg-card p-6 text-card-foreground shadow-lg backdrop:bg-black/50',
                $props.class,
            )
        "
        @click.self="closeDialog"
        @close="closeDialog"
    >
        <button
            type="button"
            :aria-label="closeLabel"
            class="absolute top-4 right-4 rounded-sm p-1 text-muted-foreground transition-colors hover:bg-accent hover:text-foreground focus-visible:ring-2 focus-visible:ring-ring focus-visible:outline-none"
            @click="closeDialog"
        >
            <svg
                aria-hidden="true"
                class="size-4"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
            >
                <path d="m18 6-12 12M6 6l12 12" />
            </svg>
        </button>
        <slot />
    </dialog>
</template>
