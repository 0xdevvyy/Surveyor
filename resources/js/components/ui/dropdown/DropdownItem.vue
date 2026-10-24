<script setup lang="ts">
import { Link } from "@inertiajs/vue3";
import { cn } from "@/lib/utils";

withDefaults(
    defineProps<{
        href?: string;
        disabled?: boolean;
        class?: string;
    }>(),
    {
        href: undefined,
        disabled: false,
        class: "",
    },
);
</script>

<template>
    <Link
        v-if="href && !disabled"
        :href="href"
        role="menuitem"
        :class="
            cn(
                'flex w-full cursor-pointer items-center rounded-sm px-2 py-1.5 text-sm outline-none transition-colors hover:bg-accent hover:text-accent-foreground focus:bg-accent focus:text-accent-foreground',
                $props.class,
            )
        "
    >
        <slot />
    </Link>
    <button
        v-else
        type="button"
        role="menuitem"
        :disabled="disabled"
        :aria-disabled="disabled ? 'true' : undefined"
        :class="
            cn(
                'flex w-full cursor-pointer items-center rounded-sm px-2 py-1.5 text-left text-sm outline-none transition-colors hover:bg-accent hover:text-accent-foreground focus:bg-accent focus:text-accent-foreground disabled:pointer-events-none disabled:opacity-50',
                $props.class,
            )
        "
    >
        <slot />
    </button>
</template>
