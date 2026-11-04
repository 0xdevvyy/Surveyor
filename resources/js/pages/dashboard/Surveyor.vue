<script setup lang="ts">
import { Head, usePage } from '@inertiajs/vue3';
import { Calendar, File, ShieldCheck } from '@lucide/vue';
import HouseholdBarangaysChart from '@/components/dashboard/HouseholdBarangaysChart.vue';
import SurveyProgressChart from '@/components/dashboard/SurveyProgressChart.vue';
import StatCard from '@/components/ui/card/StatCard.vue';

const props = defineProps<{
    metrics: {
        surveysToday: number;
        submittedSurveys: number;
        residentsReached: number;
    };
    householdBarangays: {
        name: string;
        households: number;
    }[];
}>();

const user = usePage().props.auth.user;

const metrics = [
    {
        label: 'Surveys today',
        value: props.metrics.surveysToday,
        changeLabel: 'Survey responses submitted today.',
        icon: Calendar,
    },
    {
        label: 'Submitted surveys',
        value: props.metrics.submittedSurveys,
        changeLabel: 'Survey responses submitted by you.',
        icon: File,
    },
    {
        label: 'Residents reached',
        value: props.metrics.residentsReached,
        changeLabel: 'Unique residents included in your surveys.',
        icon: ShieldCheck,
    },
];
</script>

<template>
    <Head title="Surveyor dashboard" />

    <div class="mx-auto w-full max-w-7xl p-5 sm:p-8">
        <header class="mb-6 sm:mb-8">
            <p class="text-sm font-medium text-crater-teal">
                Surveyor workspace
            </p>
            <h1 class="mt-2 text-2xl font-semibold tracking-tight sm:text-3xl">
                Welcome, {{ user.name }}
            </h1>
            <p class="mt-2 text-sm text-muted-foreground">
                Keep track of your submissions and residents reached.
            </p>
        </header>

        <section aria-label="Survey activity">
            <h2 class="mb-3 text-base font-semibold sm:mb-4">
                Your survey activity
            </h2>
            <div class="grid grid-cols-2 gap-3 sm:gap-4 xl:grid-cols-3">
                <StatCard
                    v-for="metric in metrics"
                    :key="metric.label"
                    :label="metric.label"
                    :value="metric.value"
                    :change-label="metric.changeLabel"
                    class="border-border bg-card"
                >
                    <template #icon>
                        <component
                            :is="metric.icon"
                            aria-hidden="true"
                            class="size-5 text-accent-foreground"
                        />
                    </template>
                </StatCard>
            </div>
        </section>

        <section
            aria-label="Survey charts"
            class="mt-6 grid gap-4 sm:gap-6 lg:grid-cols-2"
        >
            <SurveyProgressChart :survey-progress="props.metrics" />
            <HouseholdBarangaysChart
                :household-barangays="props.householdBarangays"
            />
        </section>

        <section
            class="mt-6 rounded-xl border border-border bg-card p-5 sm:p-6"
        >
            <h2 class="text-sm font-semibold">Your fieldwork</h2>
            <p class="mt-2 max-w-2xl text-sm leading-6 text-muted-foreground">
                You have submitted
                {{ props.metrics.submittedSurveys }} survey responses and
                reached {{ props.metrics.residentsReached }} unique residents.
            </p>
        </section>
    </div>
</template>
