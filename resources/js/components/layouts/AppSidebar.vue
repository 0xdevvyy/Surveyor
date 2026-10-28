<script setup lang="ts">
import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { PanelLeftClose, PanelLeftOpen } from '@lucide/vue';
import Sidebar from '@/components/ui/sidebar/Sidebar.vue';
import SidebarItem from '@/components/ui/sidebar/SidebarItem.vue';
import Tooltip from '@/components/ui/data-display/Tooltip.vue';
import { getNavItems, type NavItem } from '@/types/navigation/sidebar';

defineProps<{
    collapsed: boolean;
}>();

const emit = defineEmits<{
    toggleCollapse: [];
}>();

const page = usePage();

function getHref(href: NonNullable<NavItem['href']>): string {
    return typeof href === 'string' ? href : href.url;
}

function isCurrentRoute(href: NonNullable<NavItem['href']>): boolean {
    const currentPath = page.url.split('?')[0];
    const itemPath = getHref(href).split('?')[0];

    return currentPath === itemPath || currentPath.startsWith(`${itemPath}/`);
}

const items = computed(() =>
    getNavItems(page.props.auth.user.role).map((item) => ({
        title: item.label,
        href: item.href ? getHref(item.href) : undefined,
        icon: item.icon,
        active: item.href
            ? isCurrentRoute(item.href)
            : (item.children?.some((child) => isCurrentRoute(child.href)) ??
              false),
        subItems: item.children?.map((child) => ({
            title: child.label,
            href: getHref(child.href),
        })),
    })),
);
</script>

<template>
    <Sidebar
        class="h-full w-full border-sidebar-border/80 bg-sidebar shadow-xl transition-[width] duration-200 md:shadow-none"
    >
        <div
            :class="[
                'flex min-h-[4.5rem] items-center border-b border-sidebar-border/80',
                collapsed
                    ? 'justify-center px-2'
                    : 'justify-between gap-3 px-5',
            ]"
        >
            <div v-if="!collapsed" class="flex min-w-0 items-center gap-3">
                <span
                    class="flex size-10 shrink-0 items-center justify-center rounded-xl bg-primary text-sm font-bold text-primary-foreground shadow-sm"
                    aria-hidden="true"
                >
                    S
                </span>
                <div class="min-w-0">
                    <h2 class="truncate text-base font-semibold tracking-tight">
                        Surveyor
                    </h2>
                    <p class="truncate text-xs text-sidebar-foreground/60">
                        Community Survey System
                    </p>
                </div>
            </div>

            <Tooltip
                :text="collapsed ? 'Expand sidebar' : 'Collapse sidebar'"
                side="right"
                portal
                trigger-class="shrink-0"
            >
                <button
                    type="button"
                    :aria-label="
                        collapsed ? 'Expand sidebar' : 'Collapse sidebar'
                    "
                    class="hidden size-9 items-center justify-center rounded-lg text-sidebar-foreground/65 transition-colors hover:bg-sidebar-accent hover:text-sidebar-foreground focus-visible:ring-2 focus-visible:ring-sidebar-ring focus-visible:outline-none md:inline-flex"
                    @click="emit('toggleCollapse')"
                >
                    <PanelLeftOpen
                        v-if="collapsed"
                        aria-hidden="true"
                        class="size-[18px]"
                    />
                    <PanelLeftClose
                        v-else
                        aria-hidden="true"
                        class="size-[18px]"
                    />
                </button>
            </Tooltip>
        </div>

        <nav
            aria-label="Main navigation"
            :class="[
                'flex min-h-0 flex-1 flex-col gap-3 overflow-y-auto py-6',
                collapsed ? 'items-center px-2' : 'px-3',
            ]"
        >
            <p
                v-if="!collapsed"
                class="px-3 text-[11px] font-semibold tracking-[0.12em] text-sidebar-foreground/45 uppercase"
            >
                Workspace
            </p>
            <div
                :class="[
                    'flex w-full flex-col gap-1',
                    collapsed && 'items-center',
                ]"
            >
                <SidebarItem
                    v-for="item in items"
                    :key="item.title"
                    :title="item.title"
                    :href="item.href"
                    :icon="item.icon"
                    :active="item.active"
                    :sub-items="item.subItems"
                    :collapsed="collapsed"
                />
            </div>
        </nav>

        <div v-if="!collapsed" class="border-t border-sidebar-border/80 p-4">
            <p class="text-xs leading-relaxed text-sidebar-foreground/55">
                Community survey platform
            </p>
        </div>
    </Sidebar>
</template>
