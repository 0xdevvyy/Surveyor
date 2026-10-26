<script setup lang="ts">
import { computed } from "vue";
import { cn } from "@/lib/utils";
import { ChevronLeft, ChevronRight } from "@lucide/vue";

const props = withDefaults(
    defineProps<{
        totalPages: number;
        label?: string;
        class?: string;
    }>(),
    {
        label: "Pagination",
        class: "",
    },
);

const page = defineModel<number>({ default: 1 });
const safeTotalPages = computed(() =>
    Math.max(1, Math.floor(props.totalPages)),
);
const currentPage = computed(() =>
    Math.min(safeTotalPages.value, Math.max(1, Math.floor(page.value))),
);
const visiblePages = computed(() => {
    const first = Math.max(1, currentPage.value - 2);
    const last = Math.min(safeTotalPages.value, currentPage.value + 2);

    return Array.from(
        { length: last - first + 1 },
        (_, index) => first + index,
    );
});

function setPage(nextPage: number): void {
    page.value = Math.min(safeTotalPages.value, Math.max(1, nextPage));
}
</script>

<template>
    <nav
        :aria-label="label"
        :class="cn('flex items-center justify-center gap-1', $props.class)"
    >
        <button
            type="button"
            aria-label="Go to previous page"
            :disabled="currentPage <= 1"
            class="inline-flex size-9 items-center justify-center rounded-md border border-input bg-background text-sm hover:bg-accent disabled:pointer-events-none disabled:opacity-50"
            @click="setPage(currentPage - 1)"
        >
            <ChevronLeft aria-hidden="true" class="size-4" />
        </button>
        <button
            v-for="pageNumber in visiblePages"
            :key="pageNumber"
            type="button"
            :aria-label="`Go to page ${pageNumber}`"
            :aria-current="currentPage === pageNumber ? 'page' : undefined"
            :class="
                cn(
                    'inline-flex size-9 items-center justify-center rounded-md text-sm transition-colors hover:bg-accent',
                    currentPage === pageNumber &&
                        'bg-primary text-primary-foreground hover:bg-primary/90',
                )
            "
            @click="setPage(pageNumber)"
        >
            {{ pageNumber }}
        </button>
        <button
            type="button"
            aria-label="Go to next page"
            :disabled="currentPage >= safeTotalPages"
            class="inline-flex size-9 items-center justify-center rounded-md border border-input bg-background text-sm hover:bg-accent disabled:pointer-events-none disabled:opacity-50"
            @click="setPage(currentPage + 1)"
        >
            <ChevronRight aria-hidden="true" class="size-4" />
        </button>
    </nav>
</template>
