<script setup lang="ts">
import { Link } from "@inertiajs/vue3";
import type { ClassValue } from "clsx";
import { cn } from "@/lib/utils";

withDefaults(
    defineProps<{
        href?: string;
        active?: boolean;
        disabled?: boolean;
        class?: ClassValue;
    }>(),
    {
        href: undefined,
        active: false,
        disabled: false,
        class: "",
    },
);

const itemClasses =
    "flex w-full items-center gap-3 rounded-md px-3 py-2 text-sm font-medium transition-colors hover:bg-sidebar-accent hover:text-sidebar-accent-foreground focus-visible:ring-2 focus-visible:ring-sidebar-ring focus-visible:outline-none disabled:pointer-events-none disabled:opacity-50";
</script>

<template>
    <li>
        <Link
            v-if="href && !disabled"
            :href="href"
            :aria-current="active ? 'page' : undefined"
            :class="
                cn(
                    itemClasses,
                    active &&
                        'bg-sidebar-primary text-sidebar-primary-foreground hover:bg-sidebar-primary/90 hover:text-sidebar-primary-foreground',
                    $props.class,
                )
            "
        >
            <slot />
        </Link>
        <button
            v-else
            type="button"
            :disabled="disabled"
            :aria-current="active ? 'page' : undefined"
            :class="
                cn(
                    itemClasses,
                    active &&
                        'bg-sidebar-primary text-sidebar-primary-foreground hover:bg-sidebar-primary/90 hover:text-sidebar-primary-foreground',
                    $props.class,
                )
            "
        >
            <slot />
        </button>
    </li>
</template>
