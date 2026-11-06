<script setup lang="ts">
import { Head, Link, usePage } from '@inertiajs/vue3';
import { ClipboardCheck, MapPin, Users } from '@lucide/vue';
import { index as usersIndex } from '@/actions/App/Http/Controllers/UserController';
import HouseholdBarangaysChart from '@/components/dashboard/HouseholdBarangaysChart.vue';
import SurveyProgressChart from '@/components/dashboard/SurveyProgressChart.vue';
import StatCard from '@/components/ui/card/StatCard.vue';
import UserTable from '@/components/tables/UserTable.vue';
import type { PaginatedUsers } from '@/types/auth';

const props = defineProps<{
    users: PaginatedUsers;
    metrics: {
        registeredUsers: number;
        surveySubmissions: number;
        barangays: number;
    };
    householdBarangays: {
        name: string;
        households: number;
    }[];
    surveyProgressByBarangay: {
        name: string;
        totalResidents: number;
        surveyedResidents: number;
    }[];
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

    <div class="mx-auto w-full max-w-7xl p-4 sm:p-8">
        <header class="mb-6 sm:mb-8">
            <p class="text-sm font-medium text-crater-teal">Admin workspace</p>
            <h1 class="mt-2 text-2xl font-semibold tracking-tight sm:text-3xl">
                Welcome, {{ user.name }}
            </h1>
            <div class="mt-2 flex flex-wrap items-center justify-between gap-3">
                <p class="text-sm text-muted-foreground">
                    Manage the survey platform and monitor community data.
                </p>
                <Link
                    :href="usersIndex.url()"
                    class="inline-flex min-h-10 items-center justify-center rounded-md border border-input bg-background px-4 py-2 text-sm font-medium transition-colors hover:bg-accent"
                >
                    Manage users
                </Link>
            </div>
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
            aria-label="Community survey charts"
            class="mt-6 grid min-w-0 grid-cols-1 gap-4 sm:gap-6 lg:grid-cols-2"
        >
            <SurveyProgressChart
                :survey-progress-by-barangay="props.surveyProgressByBarangay"
            />
            <HouseholdBarangaysChart
                :household-barangays="props.householdBarangays"
            />
        </section>

        <UserTable
            :users="props.users"
            :current-user-id="user.id"
            class="mt-6"
        />
    </div>
</template>
