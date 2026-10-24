<script setup lang="ts">
import { Link } from "@inertiajs/vue3";
import { cn } from "@/lib/utils";

withDefaults(
    defineProps<{
        items: {
            label: string;
            href: string;
            active?: boolean;
        }[];
        label?: string;
        class?: string;
    }>(),
    {
        label: "Main navigation",
        class: "",
    },
);
</script>

<template>
    <aside
        :class="
            cn(
                'flex h-full w-64 flex-col border-r border-sidebar-border bg-sidebar text-sidebar-foreground',
                $props.class,
            )
        "
    >
        <div v-if="$slots.header" class="p-4">
            <slot name="header" />
        </div>
        <nav :aria-label="label" class="flex flex-1 flex-col gap-1 p-3">
            <Link
                v-for="item in items"
                :key="item.href"
                :href="item.href"
                :aria-current="item.active ? 'page' : undefined"
                :class="
                    cn(
                        'flex items-center gap-3 rounded-md px-3 py-2 text-sm font-medium transition-colors hover:bg-sidebar-accent hover:text-sidebar-accent-foreground',
                        item.active &&
                            'bg-sidebar-primary text-sidebar-primary-foreground hover:bg-sidebar-primary/90 hover:text-sidebar-primary-foreground',
                    )
                "
            >
                <slot name="item" :item="item">
                    {{ item.label }}
                </slot>
            </Link>
        </nav>
        <div v-if="$slots.footer" class="p-4">
            <slot name="footer" />
        </div>
    </aside>
</template>
