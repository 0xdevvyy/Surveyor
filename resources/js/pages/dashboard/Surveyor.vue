<script setup lang="ts">
import { Head, usePage } from '@inertiajs/vue3';
import { Calendar, File, ShieldCheck } from '@lucide/vue';
import AppLayout from '@/components/layouts/AppLayout.vue';
import AppSidebar from '@/components/layouts/AppSidebar.vue';
import StatCard from '@/components/ui/card/StatCard.vue';

const props = defineProps<{
    metrics: {
        surveysToday: number;
        submittedSurveys: number;
        residentsReached: number;
    };
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

    <AppLayout
        class="bg-[#f5f7f6] text-[#25313b] dark:bg-[#17232c] dark:text-[#f1f2ee]"
    >
        <template #sidebar="{ collapsed, toggleCollapse }">
            <AppSidebar
                :collapsed="collapsed"
                @toggle-collapse="toggleCollapse"
            />
        </template>

        <div class="mx-auto w-full max-w-7xl p-5 sm:p-8">
            <header class="mb-8">
                <p class="text-sm font-medium text-[#167d83]">
                    Field workspace
                </p>
                <h1
                    class="mt-2 text-2xl font-semibold tracking-tight sm:text-3xl"
                >
                    Welcome, {{ user.name }}
                </h1>
                <p class="mt-2 text-sm text-[#7b898d] dark:text-[#aab6b7]">
                    Keep track of your submissions and residents reached.
                </p>
            </header>

            <section aria-label="Survey activity">
                <h2 class="mb-4 text-base font-semibold">
                    Your survey activity
                </h2>
                <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
                    <StatCard
                        v-for="metric in metrics"
                        :key="metric.label"
                        :label="metric.label"
                        :value="metric.value"
                        :change-label="metric.changeLabel"
                        class="border-[#e4e9e6] bg-white dark:border-white/10 dark:bg-[#202e38]"
                    >
                        <template #icon>
                            <component
                                :is="metric.icon"
                                aria-hidden="true"
                                class="size-4 text-[#167d83]"
                            />
                        </template>
                    </StatCard>
                </div>
            </section>

            <section
                class="mt-6 rounded-xl border border-[#e4e9e6] bg-white p-6 dark:border-white/10 dark:bg-[#202e38]"
            >
                <h2 class="text-sm font-semibold">Your fieldwork</h2>
                <p
                    class="mt-2 max-w-2xl text-sm leading-6 text-[#7b898d] dark:text-[#aab6b7]"
                >
                    You have submitted
                    {{ props.metrics.submittedSurveys }} survey responses and
                    reached {{ props.metrics.residentsReached }} unique
                    residents.
                </p>
            </section>
        </div>
    </AppLayout>
</template>
