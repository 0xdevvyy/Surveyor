<script setup lang="ts">
import { Link, usePage } from "@inertiajs/vue3";
import { ChevronDown } from "@lucide/vue";
import type { Component } from "vue";
import { computed, ref, watch } from "vue";
import Tooltip from "@/components/ui/data-display/Tooltip.vue";

interface SubItem {
    title: string;
    href: string;
}

interface Props {
    title: string;
    icon: Component;
    href?: string;
    active?: boolean;
    subItems?: SubItem[];
    collapsed?: boolean;
}

const props = withDefaults(defineProps<Props>(), {
    href: undefined,
    active: undefined,
    subItems: () => [],
    collapsed: false,
});

const page = usePage();

function isCurrentPath(href: string): boolean {
    const currentPath = page.url.split("?")[0].replace(/\/+$/, "") || "/";
    const targetPath = href.split("?")[0].replace(/\/+$/, "") || "/";

    return (
        currentPath === targetPath ||
        (targetPath !== "/" && currentPath.startsWith(`${targetPath}/`))
    );
}

const isActive = computed(() => {
    if (props.active !== undefined) {
        return props.active;
    }

    return props.href
        ? isCurrentPath(props.href)
        : props.subItems.some((subItem) => isCurrentPath(subItem.href));
});

const hasSubItems = computed(() => props.subItems.length > 0);
const hasActiveSubItem = computed(() =>
    props.subItems.some((subItem) => isCurrentPath(subItem.href)),
);
const isExpanded = ref(isActive.value || hasActiveSubItem.value);

watch([isActive, hasActiveSubItem], ([active, subItemActive]) => {
    if (active || subItemActive) {
        isExpanded.value = true;
    }
});
</script>

<template>
    <div class="w-full space-y-1">
        <Tooltip :text="title" side="right" portal trigger-class="w-full">
            <Link
                v-if="href"
                :href="href"
                :aria-current="isActive ? 'page' : undefined"
                :class="[
                    'group relative flex w-full items-center gap-3 rounded-lg py-2.5 text-sm font-medium transition-colors focus-visible:ring-2 focus-visible:ring-sidebar-ring focus-visible:outline-none',
                    collapsed ? 'justify-center px-0' : 'px-3',
                    isActive
                        ? 'bg-sidebar-accent text-sidebar-accent-foreground'
                        : 'text-sidebar-foreground/75 hover:bg-sidebar-accent/70 hover:text-sidebar-foreground',
                ]"
            >
                <span
                    v-if="isActive && !collapsed"
                    class="absolute inset-y-2 left-0 w-0.5 rounded-full bg-primary"
                    aria-hidden="true"
                />
                <component
                    :is="icon"
                    :size="18"
                    :stroke-width="1.8"
                    :class="[
                        'shrink-0',
                        isActive
                            ? 'text-primary'
                            : 'text-sidebar-foreground/55 group-hover:text-sidebar-foreground',
                    ]"
                />
                <span :class="collapsed ? 'sr-only' : 'truncate'">{{
                    title
                }}</span>
            </Link>
            <button
                v-else
                type="button"
                :aria-expanded="isExpanded"
                :class="[
                    'group relative flex w-full items-center gap-3 rounded-lg py-2.5 text-left text-sm font-medium transition-colors focus-visible:ring-2 focus-visible:ring-sidebar-ring focus-visible:outline-none',
                    collapsed ? 'justify-center px-0' : 'px-3',
                    isActive
                        ? 'bg-sidebar-accent text-sidebar-accent-foreground'
                        : 'text-sidebar-foreground/75 hover:bg-sidebar-accent/70 hover:text-sidebar-foreground',
                ]"
                @click="isExpanded = !isExpanded"
            >
                <span
                    v-if="isActive && !collapsed"
                    class="absolute inset-y-2 left-0 w-0.5 rounded-full bg-primary"
                    aria-hidden="true"
                />
                <component
                    :is="icon"
                    :size="18"
                    :stroke-width="1.8"
                    :class="[
                        'shrink-0',
                        isActive
                            ? 'text-primary'
                            : 'text-sidebar-foreground/55 group-hover:text-sidebar-foreground',
                    ]"
                />
                <span :class="collapsed ? 'sr-only' : 'flex-1 truncate'">{{
                    title
                }}</span>
                <ChevronDown
                    v-if="!collapsed"
                    :size="16"
                    :stroke-width="1.8"
                    :class="[
                        'shrink-0 text-sidebar-foreground/45 transition-transform',
                        isExpanded && 'rotate-180',
                    ]"
                />
            </button>
        </Tooltip>

        <ul
            v-if="hasSubItems && isExpanded"
            class="ml-4 flex flex-col gap-1 border-l border-sidebar-border/80 pl-3"
        >
            <li v-for="subItem in subItems" :key="subItem.href">
                <Link
                    :href="subItem.href"
                    :aria-current="
                        isCurrentPath(subItem.href) ? 'page' : undefined
                    "
                    :class="[
                        'block rounded-md px-3 py-2 text-sm transition-colors focus-visible:ring-2 focus-visible:ring-sidebar-ring focus-visible:outline-none',
                        isCurrentPath(subItem.href)
                            ? 'font-medium text-primary'
                            : 'text-sidebar-foreground/60 hover:bg-sidebar-accent/70 hover:text-sidebar-foreground',
                    ]"
                >
                    <span class="truncate">{{ subItem.title }}</span>
                </Link>
            </li>
        </ul>
    </div>
</template>
