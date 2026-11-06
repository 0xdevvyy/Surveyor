<script setup lang="ts">
import { computed } from 'vue';
import Tooltip from '@/components/ui/data-display/Tooltip.vue';

const props = defineProps<{
    householdBarangays: {
        name: string;
        households: number;
    }[];
}>();

const hasData = computed(() =>
    props.householdBarangays.some((barangay) => barangay.households > 0),
);

const minimumChartWidth = 640;
const categoryWidth = 64;
const chartWidth = computed(() =>
    Math.max(
        minimumChartWidth,
        props.householdBarangays.length * categoryWidth + 58,
    ),
);
const chartHeight = 330;
const chartTop = 40;
const chartBottom = 220;
const chartPlotHeight = chartBottom - chartTop;

const maximumHouseholdCount = computed(() =>
    Math.max(
        ...props.householdBarangays.map((barangay) => barangay.households),
        1,
    ),
);

const bars = computed(() => {
    const plotWidth = chartWidth.value - 58;
    const step = plotWidth / Math.max(props.householdBarangays.length, 1);
    const width = Math.min(36, step * 0.55);

    return props.householdBarangays.map((barangay, index) => {
        const height =
            (barangay.households / maximumHouseholdCount.value) *
            chartPlotHeight;
        const center = 58 + step * index + step / 2;

        return {
            ...barangay,
            x: center - width / 2,
            y: chartBottom - height,
            width,
            height,
            labelX: center,
            labelY: chartBottom + 18,
        };
    });
});

const gridLines = computed(() =>
    [0, 0.5, 1].map((fraction) => ({
        y: chartBottom - chartPlotHeight * fraction,
        value: Math.round(maximumHouseholdCount.value * fraction),
    })),
);
</script>

<template>
    <article class="min-w-0 rounded-xl border border-border bg-card p-4 sm:p-6">
        <h2 class="text-base font-semibold">Households by Barangay</h2>
        <p class="mt-1 text-sm text-muted-foreground">
            Household records across barangays.
        </p>

        <div
            v-if="hasData"
            class="mt-4 w-full overflow-x-auto pb-2"
            tabindex="0"
            aria-label="Scroll horizontally to view all barangays"
        >
            <div
                class="relative shrink-0"
                :style="{
                    width: `${chartWidth}px`,
                    height: `${chartHeight}px`,
                }"
                role="group"
                aria-label="Households by barangay bar chart"
            >
                <svg
                    :viewBox="`0 0 ${chartWidth} ${chartHeight}`"
                    class="absolute inset-0 size-full"
                    aria-hidden="true"
                >
                    <g
                        v-for="line in gridLines"
                        :key="line.value"
                        aria-hidden="true"
                    >
                        <line
                            x1="42"
                            :y1="line.y"
                            :x2="chartWidth"
                            :y2="line.y"
                            class="stroke-border"
                            stroke-dasharray="4 4"
                        />
                        <text
                            x="34"
                            :y="line.y + 4"
                            text-anchor="end"
                            class="fill-muted-foreground text-[11px]"
                        >
                            {{ line.value }}
                        </text>
                    </g>

                    <g v-for="bar in bars" :key="bar.name">
                        <text
                            :x="bar.labelX"
                            :y="bar.labelY"
                            :transform="`rotate(-45 ${bar.labelX} ${bar.labelY})`"
                            text-anchor="end"
                            class="fill-muted-foreground text-[11px]"
                        >
                            {{ bar.name }}
                        </text>
                    </g>
                </svg>

                <Tooltip
                    v-for="bar in bars"
                    :key="bar.name"
                    :text="`${bar.name}: ${bar.households} households`"
                    side="top"
                    trigger-class="absolute"
                    :style="{
                        left: `${bar.x}px`,
                        top: `${bar.y}px`,
                        width: `${bar.width}px`,
                        height: `${bar.height}px`,
                    }"
                >
                    <span
                        class="h-full w-full rounded-t-[5px] bg-chart-2"
                        tabindex="0"
                        :aria-label="`${bar.name}: ${bar.households} households`"
                    />
                </Tooltip>
            </div>
        </div>
        <p v-else class="mt-6 py-16 text-center text-sm text-muted-foreground">
            No data available.
        </p>
    </article>
</template>
