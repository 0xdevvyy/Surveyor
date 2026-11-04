<script setup lang="ts">
import { computed } from 'vue';

const props = defineProps<{
    householdBarangays: {
        name: string;
        households: number;
    }[];
}>();

const hasData = computed(() =>
    props.householdBarangays.some((barangay) => barangay.households > 0),
);

const chartWidth = 640;
const chartHeight = 260;
const chartTop = 16;
const chartBottom = 210;
const chartPlotHeight = chartBottom - chartTop;

const maximumHouseholdCount = computed(() =>
    Math.max(
        ...props.householdBarangays.map((barangay) => barangay.households),
        1,
    ),
);

const bars = computed(() => {
    const step = chartWidth / Math.max(props.householdBarangays.length, 1);
    const width = Math.min(42, step * 0.6);

    return props.householdBarangays.map((barangay, index) => {
        const height =
            (barangay.households / maximumHouseholdCount.value) *
            chartPlotHeight;
        const center = step * index + step / 2;

        return {
            ...barangay,
            x: center - width / 2,
            y: chartBottom - height,
            width,
            height,
            label:
                barangay.name.length > 12
                    ? `${barangay.name.slice(0, 11)}…`
                    : barangay.name,
            labelX: center,
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
    <article class="rounded-xl border border-border bg-card p-5 sm:p-6">
        <h2 class="text-base font-semibold">Households by Barangay</h2>
        <p class="mt-1 text-sm text-muted-foreground">
            Household records across barangays.
        </p>

        <div v-if="hasData" class="mt-4 w-full overflow-x-auto">
            <svg
                :viewBox="`0 0 ${chartWidth} ${chartHeight}`"
                class="h-64 w-full min-w-[32rem]"
                role="img"
                aria-label="Households by barangay bar chart"
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

                <g
                    v-for="bar in bars"
                    :key="bar.name"
                    :aria-label="`${bar.name}: ${bar.households} households`"
                >
                    <title>
                        {{ bar.name }}: {{ bar.households }} households
                    </title>
                    <rect
                        :x="bar.x"
                        :y="bar.y"
                        :width="bar.width"
                        :height="bar.height"
                        rx="5"
                        class="fill-chart-2"
                    />
                    <text
                        :x="bar.labelX"
                        :y="chartBottom + 22"
                        text-anchor="middle"
                        class="fill-muted-foreground text-[11px]"
                    >
                        {{ bar.label }}
                    </text>
                </g>
            </svg>
        </div>
        <p v-else class="mt-6 py-16 text-center text-sm text-muted-foreground">
            No data available.
        </p>
    </article>
</template>
