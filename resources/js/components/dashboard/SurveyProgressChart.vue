<script setup lang="ts">
import { computed } from 'vue';

const props = defineProps<{
    surveyProgress: {
        surveysToday: number;
        submittedSurveys: number;
    };
}>();

const todaySubmissions = computed(() =>
    Math.min(
        props.surveyProgress.surveysToday,
        props.surveyProgress.submittedSurveys,
    ),
);
const earlierSubmissions = computed(() =>
    Math.max(props.surveyProgress.submittedSurveys - todaySubmissions.value, 0),
);
const totalSubmissions = computed(() => props.surveyProgress.submittedSurveys);
const hasData = computed(() => totalSubmissions.value > 0);
const todayPercentage = computed(() =>
    totalSubmissions.value > 0
        ? (todaySubmissions.value / totalSubmissions.value) * 100
        : 0,
);
</script>

<template>
    <article class="rounded-xl border border-border bg-card p-5 sm:p-6">
        <h2 class="text-base font-semibold">Survey Progress</h2>
        <p class="mt-1 text-sm text-muted-foreground">
            Submissions made today compared with earlier submissions.
        </p>

        <div
            v-if="hasData"
            class="mt-4 flex flex-col items-center gap-5 sm:flex-row sm:justify-center"
        >
            <div
                class="relative flex size-52 shrink-0 items-center justify-center rounded-full"
                role="img"
                :aria-label="`${todaySubmissions} submissions today, ${earlierSubmissions} earlier, ${totalSubmissions} total`"
                :style="{
                    background: `conic-gradient(var(--chart-2) 0 ${todayPercentage}%, var(--muted) ${todayPercentage}% 100%)`,
                }"
            >
                <div
                    class="absolute inset-5 rounded-full bg-card"
                    aria-hidden="true"
                />
                <div class="relative text-center">
                    <div class="text-4xl font-semibold tracking-tight">
                        {{ totalSubmissions.toLocaleString('en-US') }}
                    </div>
                    <div class="mt-1 text-sm text-muted-foreground">
                        Submissions
                    </div>
                </div>
            </div>

            <dl class="grid w-full max-w-xs gap-4">
                <div class="flex items-center justify-between gap-4">
                    <dt
                        class="flex items-center gap-2 text-sm text-muted-foreground"
                    >
                        <span
                            class="size-3 rounded-full bg-chart-2"
                            aria-hidden="true"
                        />
                        Today
                    </dt>
                    <dd class="font-semibold">
                        {{ todaySubmissions.toLocaleString('en-US') }}
                    </dd>
                </div>
                <div class="flex items-center justify-between gap-4">
                    <dt
                        class="flex items-center gap-2 text-sm text-muted-foreground"
                    >
                        <span
                            class="size-3 rounded-full bg-muted-foreground/30"
                            aria-hidden="true"
                        />
                        Earlier
                    </dt>
                    <dd class="font-semibold">
                        {{ earlierSubmissions.toLocaleString('en-US') }}
                    </dd>
                </div>
            </dl>
        </div>
        <p v-else class="mt-6 py-16 text-center text-sm text-muted-foreground">
            No data available.
        </p>
    </article>
</template>
