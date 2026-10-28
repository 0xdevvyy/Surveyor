<script setup lang="ts">
import { Head, usePage } from '@inertiajs/vue3';
import { Building2, File, User } from '@lucide/vue';
import AppLayout from '@/components/layouts/AppLayout.vue';
import AppSidebar from '@/components/layouts/AppSidebar.vue';
import StatCard from '@/components/ui/card/StatCard.vue';

const props = defineProps<{
    metrics: {
        householdRecords: number;
        surveyRecords: number;
        hasPersonalInformation: boolean;
    };
}>();

const user = usePage().props.auth.user;

const metrics = [
    {
        label: 'Household profile',
        value: props.metrics.householdRecords,
        changeLabel: 'Household records linked to your account.',
        icon: Building2,
    },
    {
        label: 'Survey status',
        value: props.metrics.surveyRecords,
        changeLabel: 'Survey responses linked to your account.',
        icon: File,
    },
    {
        label: 'Personal information',
        value: props.metrics.hasPersonalInformation ? 'Complete' : 'Missing',
        changeLabel: 'Profile information saved in the system.',
        icon: User,
    },
];
</script>

<template>
    <Head title="Resident dashboard" />

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
                    Resident workspace
                </p>
                <h1
                    class="mt-2 text-2xl font-semibold tracking-tight sm:text-3xl"
                >
                    Welcome, {{ user.name }}
                </h1>
                <p class="mt-2 text-sm text-[#7b898d] dark:text-[#aab6b7]">
                    View your household information and community survey status.
                </p>
            </header>

            <section aria-label="Resident information">
                <h2 class="mb-4 text-base font-semibold">Your information</h2>
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
                <h2 class="text-sm font-semibold">Household survey</h2>
                <p
                    class="mt-2 max-w-2xl text-sm leading-6 text-[#7b898d] dark:text-[#aab6b7]"
                >
                    Your account is linked to
                    {{ props.metrics.householdRecords }} household record(s) and
                    {{ props.metrics.surveyRecords }} survey response(s).
                </p>
            </section>
        </div>
    </AppLayout>
</template>
