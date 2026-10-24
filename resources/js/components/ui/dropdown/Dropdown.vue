<script setup lang="ts">
import { onBeforeUnmount, onMounted, ref } from "vue";
import { cn } from "@/lib/utils";

withDefaults(
    defineProps<{
        align?: "start" | "end";
        class?: string;
    }>(),
    {
        align: "start",
        class: "",
    },
);

const rootElement = ref<HTMLElement | null>(null);
const triggerElement = ref<HTMLElement | null>(null);
const menuElement = ref<HTMLDivElement | null>(null);
const isOpen = ref(false);

function closeMenu(restoreFocus = false): void {
    isOpen.value = false;

    if (restoreFocus) {
        triggerElement.value
            ?.querySelector<HTMLElement>('button, a[href], [tabindex="0"]')
            ?.focus();
    }
}

function handleDocumentPointerDown(event: PointerEvent): void {
    if (
        event.target instanceof Node &&
        !rootElement.value?.contains(event.target)
    ) {
        closeMenu();
    }
}

function handleDocumentKeydown(event: KeyboardEvent): void {
    if (!isOpen.value) {
        return;
    }

    if (event.key === "Escape") {
        event.preventDefault();
        closeMenu(true);
        return;
    }

    if (event.key !== "ArrowDown" && event.key !== "ArrowUp") {
        return;
    }

    const menuItems = menuElement.value?.querySelectorAll<HTMLElement>(
        '[role="menuitem"]:not([aria-disabled="true"])',
    );

    if (!menuItems?.length) {
        return;
    }

    event.preventDefault();
    const currentIndex = Array.from(menuItems).indexOf(
        document.activeElement as HTMLElement,
    );
    const direction = event.key === "ArrowDown" ? 1 : -1;
    const nextIndex =
        currentIndex === -1
            ? direction === 1
                ? 0
                : menuItems.length - 1
            : (currentIndex + direction + menuItems.length) % menuItems.length;

    menuItems[nextIndex].focus();
}

onMounted(() => {
    document.addEventListener("pointerdown", handleDocumentPointerDown);
    document.addEventListener("keydown", handleDocumentKeydown);
});

onBeforeUnmount(() => {
    document.removeEventListener("pointerdown", handleDocumentPointerDown);
    document.removeEventListener("keydown", handleDocumentKeydown);
});
</script>

<template>
    <div ref="rootElement" class="relative inline-flex">
        <div
            ref="triggerElement"
            class="inline-flex"
            @click="isOpen = !isOpen"
            @keydown.enter.prevent="isOpen = !isOpen"
            @keydown.space.prevent="isOpen = !isOpen"
            @keydown.down.prevent="
                isOpen = true;
                menuElement
                    ?.querySelector<HTMLElement>(
                        '[role=menuitem]:not([aria-disabled=true])',
                    )
                    ?.focus();
            "
        >
            <slot name="trigger" :open="isOpen" />
        </div>
        <div
            v-if="isOpen"
            ref="menuElement"
            role="menu"
            :class="
                cn(
                    'absolute top-full z-50 mt-2 min-w-40 rounded-md border border-border bg-popover p-1 text-popover-foreground shadow-md',
                    align === 'end' ? 'right-0' : 'left-0',
                    $props.class,
                )
            "
            @click="closeMenu()"
        >
            <slot />
        </div>
    </div>
</template>
