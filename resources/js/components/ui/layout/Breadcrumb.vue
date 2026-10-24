<script setup lang="ts">
import { Link } from "@inertiajs/vue3";
import { cn } from "@/lib/utils";

withDefaults(
    defineProps<{
        items: {
            label: string;
            href?: string;
        }[];
        class?: string;
    }>(),
    {
        class: "",
    },
);
</script>

<template>
    <nav aria-label="Breadcrumb" :class="cn('text-sm', $props.class)">
        <ol class="flex flex-wrap items-center gap-2">
            <li
                v-for="(item, index) in items"
                :key="`${item.label}-${index}`"
                class="flex items-center gap-2"
            >
                <Link
                    v-if="item.href && index < items.length - 1"
                    :href="item.href"
                    class="text-muted-foreground transition-colors hover:text-foreground"
                >
                    {{ item.label }}
                </Link>
                <span
                    v-else
                    :aria-current="
                        index === items.length - 1 ? 'page' : undefined
                    "
                    :class="
                        index === items.length - 1
                            ? 'font-medium text-foreground'
                            : 'text-muted-foreground'
                    "
                >
                    {{ item.label }}
                </span>
                <span
                    v-if="index < items.length - 1"
                    aria-hidden="true"
                    class="text-muted-foreground/60"
                >
                    /
                </span>
            </li>
        </ol>
    </nav>
</template>
