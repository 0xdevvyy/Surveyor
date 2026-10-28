<script setup lang="ts">
import { Menu, X } from '@lucide/vue';
import { cn } from '@/lib/utils';
import {
    getSidebarCollapsed,
    setSidebarCollapsed,
} from '@/types/utils/sidebar';
import { computed, onMounted, onUnmounted, ref, watch } from 'vue';

withDefaults(
    defineProps<{
        class?: string;
    }>(),
    {
        class: '',
    },
);

const isSidebarOpen = ref(false);
const isSidebarCollapsed = ref(false);
const isDesktop = ref(false);
const isSidebarCollapsedOnDesktop = computed(
    () => isDesktop.value && isSidebarCollapsed.value,
);
let desktopMediaQuery: MediaQueryList | undefined;

function updateDesktopState(): void {
    if (!desktopMediaQuery) {
        return;
    }

    isDesktop.value = desktopMediaQuery.matches;
}

function closeSidebarOnNavigation(event: MouseEvent): void {
    if (event.target instanceof Element && event.target.closest('a')) {
        isSidebarOpen.value = false;
    }
}

watch(isDesktop, (desktop) => {
    if (desktop) {
        isSidebarOpen.value = false;
    }
});

function toggleSidebarCollapsed(): void {
    isSidebarCollapsed.value = !isSidebarCollapsed.value;
    setSidebarCollapsed(isSidebarCollapsed.value);
}

onMounted(() => {
    isSidebarCollapsed.value = getSidebarCollapsed();
    desktopMediaQuery = window.matchMedia('(min-width: 768px)');
    updateDesktopState();
    desktopMediaQuery.addEventListener('change', updateDesktopState);
});

onUnmounted(() => {
    desktopMediaQuery?.removeEventListener('change', updateDesktopState);
});
</script>

<template>
    <div
        :class="
            cn(
                'flex h-dvh flex-col overflow-hidden bg-background',
                $props.class,
            )
        "
        @keydown.esc="isSidebarOpen = false"
    >
        <slot name="navbar" />
        <div class="flex min-h-0 flex-1">
            <header
                class="fixed inset-x-0 top-0 z-30 flex h-16 items-center gap-3 border-b border-sidebar-border bg-background px-4 md:hidden"
            >
                <button
                    type="button"
                    aria-label="Toggle navigation"
                    aria-controls="app-sidebar"
                    :aria-expanded="isSidebarOpen"
                    class="inline-flex size-10 items-center justify-center rounded-lg text-foreground transition-colors hover:bg-accent focus-visible:ring-2 focus-visible:ring-ring focus-visible:outline-none"
                    @click="isSidebarOpen = !isSidebarOpen"
                >
                    <X v-if="isSidebarOpen" aria-hidden="true" class="size-5" />
                    <Menu v-else aria-hidden="true" class="size-5" />
                </button>
                <span class="text-sm font-semibold">Surveyor</span>
            </header>

            <button
                v-if="isSidebarOpen"
                type="button"
                aria-label="Close navigation"
                class="fixed inset-0 z-40 bg-black/50 md:hidden"
                @click="isSidebarOpen = false"
            />
            <div
                id="app-sidebar"
                :inert="!isDesktop && !isSidebarOpen"
                :class="[
                    'fixed inset-y-0 left-0 z-50 w-[min(18rem,calc(100vw-3rem))] transform transition-[width,transform] duration-200 ease-in-out md:relative md:z-auto md:translate-x-0 md:transform-none',
                    isSidebarOpen
                        ? 'translate-x-0 shadow-xl'
                        : '-translate-x-full md:shadow-none',
                    isSidebarCollapsedOnDesktop ? 'md:w-20' : 'md:w-72',
                ]"
                @click="closeSidebarOnNavigation"
            >
                <slot
                    name="sidebar"
                    :collapsed="isSidebarCollapsedOnDesktop"
                    :toggle-collapse="toggleSidebarCollapsed"
                />
            </div>
            <main class="min-h-0 min-w-0 flex-1 overflow-y-auto pt-16 md:pt-0">
                <slot />
            </main>
        </div>
        <slot name="footer" />
    </div>
</template>
