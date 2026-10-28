<script setup lang="ts">
import { Head, usePage } from '@inertiajs/vue3';
import { ClipboardCheck, MapPin, Users } from '@lucide/vue';
import AppLayout from '@/components/layouts/AppLayout.vue';
import AppSidebar from '@/components/layouts/AppSidebar.vue';
import StatCard from '@/components/ui/card/StatCard.vue';

const props = defineProps<{
    metrics: {
        registeredUsers: number;
        surveySubmissions: number;
        barangays: number;
    };
}>();

const user = usePage().props.auth.user;

const metrics = [
    {
        label: 'Registered users',
        value: props.metrics.registeredUsers,
        changeLabel: 'Accounts registered on the platform.',
        icon: Users,
    },
    {
        label: 'Survey submissions',
        value: props.metrics.surveySubmissions,
        changeLabel: 'Responses collected across all roles.',
        icon: ClipboardCheck,
    },
    {
        label: 'Barangays',
        value: props.metrics.barangays,
        changeLabel: 'Locations available in the system.',
        icon: MapPin,
    },
];
</script>

<template>
    <Head title="Admin dashboard" />

    <AppLayout
        class="bg-[#f5f7f6] text-[#25313b] dark:bg-[#17232c] dark:text-[#f1f2ee]"
    >
        <template #sidebar="{ collapsed, toggleCollapse }">
            <AppSidebar
                :collapsed="collapsed"
                @toggle-collapse="toggleCollapse"
            />
        </template>

        <div class="mx-auto w-full max-w-7xl p-4 sm:p-8">
            <header class="mb-6 sm:mb-8">
                <p class="text-sm font-medium text-[#167d83]">
                    Admin workspace
                </p>
                <h1
                    class="mt-2 text-2xl font-semibold tracking-tight sm:text-3xl"
                >
                    Welcome, {{ user.name }}
                </h1>
                <p class="mt-2 text-sm text-[#7b898d] dark:text-[#aab6b7]">
                    Manage the survey platform and monitor community data.
                </p>
            </header>

            <section aria-label="Platform overview">
                <h2 class="mb-3 text-base font-semibold sm:mb-4">
                    Platform overview
                </h2>
                <div class="grid grid-cols-2 gap-3 sm:gap-4 xl:grid-cols-3">
                    <StatCard
                        v-for="metric in metrics"
                        :key="metric.label"
                        :label="metric.label"
                        :value="metric.value"
                        :change-label="metric.changeLabel"
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
                class="mt-4 rounded-xl border border-[#e4e9e6] bg-white p-4 sm:mt-6 sm:p-6 dark:border-white/10 dark:bg-[#202e38]"
            >
                <h2 class="text-sm font-semibold">Getting started</h2>
                <p
                    class="mt-2 max-w-2xl text-sm leading-6 text-[#7b898d] dark:text-[#aab6b7]"
                >
                    Use the overview above to monitor registered accounts,
                    survey submissions, and barangay coverage.
                </p>
            </section>
        </div>
    </AppLayout>
</template>
