<script setup lang="ts">
import { computed } from 'vue';

const props = defineProps<{
    surveyProgressByBarangay: {
        name: string;
        totalResidents: number;
        surveyedResidents: number;
    }[];
}>();

const barangayProgress = computed(() =>
    props.surveyProgressByBarangay.map((barangay) => ({
        ...barangay,
        percentage:
            barangay.totalResidents > 0
                ? Math.min(
                      Math.round(
                          (barangay.surveyedResidents /
                              barangay.totalResidents) *
                              100,
                      ),
                      100,
                  )
                : 0,
    })),
);
</script>

<template>
    <article class="min-w-0 rounded-xl border border-border bg-card p-4 sm:p-6">
        <h2 class="text-base font-semibold">Survey Progress by Barangay</h2>
        <p class="mt-1 text-sm text-muted-foreground">
            Residents surveyed compared with residents registered in each
            barangay.
        </p>

        <div
            v-if="barangayProgress.length"
            class="mt-5 max-h-80 space-y-5 overflow-y-auto pr-2"
            role="region"
            aria-label="Survey progress for each barangay"
            tabindex="0"
        >
            <div
                v-for="barangay in barangayProgress"
                :key="barangay.name"
                class="grid min-w-0 gap-2"
            >
                <div
                    class="flex flex-wrap items-baseline justify-between gap-x-3 gap-y-1"
                >
                    <h3 class="min-w-0 truncate text-sm font-medium">
                        {{ barangay.name }}
                    </h3>
                    <p class="shrink-0 text-xs text-muted-foreground">
                        {{ barangay.surveyedResidents.toLocaleString('en-US') }}
                        /
                        {{ barangay.totalResidents.toLocaleString('en-US') }}
                        residents · {{ barangay.percentage }}%
                    </p>
                </div>
                <div
                    class="h-2.5 w-full overflow-hidden rounded-full bg-muted"
                    role="progressbar"
                    :aria-label="`${barangay.name} survey progress`"
                    :aria-valuenow="barangay.percentage"
                    :aria-valuemin="0"
                    :aria-valuemax="100"
                    :aria-valuetext="`${barangay.percentage}% complete`"
                >
                    <div
                        class="h-full rounded-full bg-chart-2 transition-[width]"
                        :style="{ width: `${barangay.percentage}%` }"
                    />
                </div>
            </div>
        </div>
        <p v-else class="mt-6 py-16 text-center text-sm text-muted-foreground">
            No data available.
        </p>
    </article>
</template>
