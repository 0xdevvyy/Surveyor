<script setup lang="ts">
import { cn } from "@/lib/utils";

withDefaults(
    defineProps<{
        scope?: "col" | "row" | "colgroup" | "rowgroup";
        class?: string;
    }>(),
    {
        scope: "col",
        class: "",
    },
);
</script>

<template>
    <th
        :scope="scope"
        :class="
            cn(
                'h-12 px-4 text-left align-middle font-medium whitespace-nowrap text-muted-foreground',
                $props.class,
            )
        "
    >
        <slot />
    </th>
</template>
