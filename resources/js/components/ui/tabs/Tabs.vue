<script setup lang="ts">
import { computed } from "vue";
import { cn } from "@/lib/utils";

const props = withDefaults(
    defineProps<{
        items: {
            label: string;
            value: string;
            disabled?: boolean;
        }[];
        class?: string;
    }>(),
    {
        class: "",
    },
);

const model = defineModel<string>();
const selectedItem = computed(
    () =>
        props.items.find(
            (item) => item.value === model.value && !item.disabled,
        ) ?? props.items.find((item) => !item.disabled),
);

function selectTab(value: string): void {
    const item = props.items.find((candidate) => candidate.value === value);

    if (item && !item.disabled) {
        model.value = value;
    }
}

function moveFocus(currentIndex: number, direction: -1 | 1): void {
    const enabledItems = props.items.filter((item) => !item.disabled);

    if (enabledItems.length === 0) {
        return;
    }

    const currentItem = props.items[currentIndex];
    const enabledIndex = enabledItems.findIndex(
        (item) => item.value === currentItem?.value,
    );
    const nextIndex =
        (enabledIndex + direction + enabledItems.length) % enabledItems.length;

    selectTab(enabledItems[nextIndex].value);
    document.getElementById(`tab-${enabledItems[nextIndex].value}`)?.focus();
}
</script>

<template>
    <div :class="cn('grid gap-4', $props.class)">
        <div
            role="tablist"
            class="inline-flex min-h-10 w-fit items-center justify-center rounded-md bg-muted p-1 text-muted-foreground"
        >
            <button
                v-for="(item, index) in items"
                :id="`tab-${item.value}`"
                :key="item.value"
                type="button"
                role="tab"
                :aria-selected="selectedItem?.value === item.value"
                :aria-controls="`panel-${item.value}`"
                :tabindex="selectedItem?.value === item.value ? 0 : -1"
                :disabled="item.disabled"
                :class="
                    cn(
                        'inline-flex items-center justify-center rounded-sm px-3 py-1.5 text-sm font-medium whitespace-nowrap transition-all focus-visible:ring-2 focus-visible:ring-ring focus-visible:outline-none disabled:pointer-events-none disabled:opacity-50',
                        selectedItem?.value === item.value &&
                            'bg-background text-foreground shadow-sm',
                    )
                "
                @click="selectTab(item.value)"
                @keydown.right.prevent="moveFocus(index, 1)"
                @keydown.left.prevent="moveFocus(index, -1)"
                @keydown.home.prevent="
                    selectTab(
                        items.find((candidate) => !candidate.disabled)?.value ??
                            '',
                    )
                "
                @keydown.end.prevent="
                    selectTab(
                        [...items]
                            .reverse()
                            .find((candidate) => !candidate.disabled)?.value ??
                            '',
                    )
                "
            >
                {{ item.label }}
            </button>
        </div>
        <section
            v-if="selectedItem"
            :id="`panel-${selectedItem.value}`"
            role="tabpanel"
            :aria-labelledby="`tab-${selectedItem.value}`"
            tabindex="0"
            class="focus-visible:ring-2 focus-visible:ring-ring focus-visible:outline-none"
        >
            <slot :value="selectedItem.value" />
        </section>
    </div>
</template>
