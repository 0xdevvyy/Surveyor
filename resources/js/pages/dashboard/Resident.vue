<script setup lang="ts">
import { Head, usePage } from '@inertiajs/vue3';
import {
    CalendarDays,
    CheckCircle2,
    ClipboardCheck,
    House,
    MapPin,
    UserRound,
    UsersRound,
} from '@lucide/vue';
import SectionCard from '@/components/ui/card/SectionCard.vue';
import StatCard from '@/components/ui/card/StatCard.vue';

const props = defineProps<{
    metrics: {
        householdRecords: number;
        surveyRecords: number;
        hasPersonalInformation: boolean;
    };
}>();

const user = usePage().props.auth.user;
const latestSurvey: { submittedAt: string | null } | null = {
    submittedAt: '2026-10-28T08:30:00.000Z',
};
const household: { householdNumber: string; barangay: string } | null = {
    householdNumber: 'HH-2026-0042',
    barangay: 'Poblacion, Capas',
};
const familyMembers: { id: string; name: string; relationship: string }[] = [
    { id: '1', name: user.name, relationship: 'Head' },
    { id: '2', name: 'Maria Dela Cruz', relationship: 'Spouse' },
    { id: '3', name: 'Ana Dela Cruz', relationship: 'Child' },
    { id: '4', name: 'Pedro Dela Cruz', relationship: 'Child' },
    { id: '5', name: 'Rosa Santos', relationship: 'Parent' },
];

const metrics = [
    {
        label: 'Surveys submitted',
        value: props.metrics.surveyRecords,
        changeLabel: 'Responses linked to your account.',
        icon: ClipboardCheck,
    },
    {
        label: 'Household records',
        value: props.metrics.householdRecords,
        changeLabel: 'Households linked to your account.',
        icon: House,
    },
    {
        label: 'Household members',
        value: familyMembers.length,
        changeLabel: 'Members listed in your household roster.',
        icon: UsersRound,
    },
    {
        label: 'Personal information',
        value: props.metrics.hasPersonalInformation ? 'Complete' : 'Missing',
        changeLabel: 'Your resident profile information.',
        icon: UserRound,
    },
];

function formatDate(date: string | null): string {
    if (!date) {
        return 'Date unavailable';
    }

    return new Intl.DateTimeFormat('en-US', {
        month: 'short',
        day: 'numeric',
        year: 'numeric',
    }).format(new Date(date));
}
</script>

<template>
    <Head title="Resident dashboard" />

    <div class="mx-auto w-full max-w-7xl space-y-6 p-4 sm:space-y-8 sm:p-8">
        <header
            class="relative isolate overflow-hidden rounded-3xl border border-primary/10 bg-linear-to-br from-primary via-primary to-crater-teal p-6 text-primary-foreground shadow-sm sm:p-8"
        >
            <div
                class="pointer-events-none absolute -right-8 -bottom-16 -z-10 hidden h-64 w-[48%] text-primary-foreground/15 sm:block"
                aria-hidden="true"
            >
                <svg
                    viewBox="0 0 520 230"
                    fill="none"
                    class="h-full w-full"
                    preserveAspectRatio="xMidYMax slice"
                >
                    <path
                        d="M0 164 82 104l47 29 76-77 57 53 73-78 50 42 69-54 66 66v145H0z"
                        fill="currentColor"
                    />
                    <path
                        d="m0 188 85-54 63 30 88-56 58 37 81-53 72 45 73-35v98H0z"
                        fill="currentColor"
                        opacity=".65"
                    />
                </svg>
            </div>

            <div class="relative max-w-2xl">
                <p
                    class="flex items-center gap-2 text-xs font-semibold tracking-[0.16em] text-primary-foreground/75 uppercase"
                >
                    <House aria-hidden="true" class="size-4" />
                    Capas resident portal
                </p>
                <h1
                    class="mt-4 text-3xl font-semibold tracking-tight sm:text-4xl"
                >
                    Welcome back, {{ user.name }}!
                </h1>
                <p
                    class="mt-3 max-w-xl text-sm leading-6 text-primary-foreground/80 sm:text-base"
                >
                    Here’s an overview of your household and community survey
                    information.
                </p>
            </div>
        </header>

        <section aria-label="Resident overview">
            <div class="grid grid-cols-2 gap-3 sm:gap-4 xl:grid-cols-4">
                <StatCard
                    v-for="metric in metrics"
                    :key="metric.label"
                    :label="metric.label"
                    :value="metric.value"
                    :change-label="metric.changeLabel"
                    class="border-border bg-card shadow-sm"
                >
                    <template #icon>
                        <component
                            :is="metric.icon"
                            aria-hidden="true"
                            class="size-5 text-primary"
                        />
                    </template>
                </StatCard>
            </div>
        </section>

        <section
            aria-label="Latest survey and profile"
            class="grid min-w-0 gap-4 lg:grid-cols-[1.35fr_1fr] lg:gap-6"
        >
            <SectionCard class="min-w-0">
                <template #header>
                    <div class="flex items-center gap-3">
                        <span
                            class="flex size-10 shrink-0 items-center justify-center rounded-xl bg-accent text-accent-foreground"
                        >
                            <ClipboardCheck aria-hidden="true" class="size-5" />
                        </span>
                        <div>
                            <h2 class="font-semibold">Latest survey</h2>
                            <p class="text-sm text-muted-foreground">
                                Your most recent household survey response.
                            </p>
                        </div>
                    </div>
                </template>
                <template #actions>
                    <span
                        v-if="latestSurvey"
                        class="inline-flex shrink-0 items-center gap-1.5 rounded-full bg-accent px-3 py-1 text-xs font-medium text-accent-foreground"
                    >
                        <CheckCircle2 aria-hidden="true" class="size-3.5" />
                        Submitted
                    </span>
                </template>

                <div
                    v-if="latestSurvey"
                    class="grid gap-4 sm:grid-cols-[minmax(0,1fr)_auto] sm:items-end"
                >
                    <div>
                        <p class="text-lg font-semibold tracking-tight">
                            Household and family information
                        </p>
                        <p
                            class="mt-4 flex items-center gap-2 text-sm text-muted-foreground"
                        >
                            <CalendarDays
                                aria-hidden="true"
                                class="size-4 text-primary"
                            />
                            Submitted
                            {{ formatDate(latestSurvey.submittedAt) }}
                        </p>
                    </div>
                    <p
                        class="rounded-xl bg-secondary px-4 py-3 text-sm text-secondary-foreground"
                    >
                        Thank you for helping keep community records up to date.
                    </p>
                </div>
                <p
                    v-else
                    class="rounded-xl bg-secondary p-4 text-sm leading-6 text-muted-foreground"
                >
                    You don’t have a survey response yet. When a surveyor
                    records your information, it will appear here.
                </p>
            </SectionCard>

            <SectionCard class="border-primary/10 bg-accent/60">
                <template #header>
                    <div class="flex items-center gap-3">
                        <span
                            class="flex size-10 shrink-0 items-center justify-center rounded-xl bg-card text-accent-foreground"
                        >
                            <UserRound aria-hidden="true" class="size-5" />
                        </span>
                        <div>
                            <h2 class="font-semibold">Profile reminder</h2>
                            <p class="text-sm text-muted-foreground">
                                Keep your resident information up to date.
                            </p>
                        </div>
                    </div>
                </template>

                <div class="rounded-xl border border-border/70 bg-card/80 p-4">
                    <p class="font-semibold">
                        {{
                            props.metrics.hasPersonalInformation
                                ? 'Your profile is up to date'
                                : 'Complete your resident profile'
                        }}
                    </p>
                    <p class="mt-2 text-sm leading-6 text-muted-foreground">
                        {{
                            props.metrics.hasPersonalInformation
                                ? 'Your personal information is saved. Review it whenever your contact details change.'
                                : 'Add your personal information so your resident profile is complete.'
                        }}
                    </p>
                </div>
            </SectionCard>
        </section>

        <section
            aria-label="Household details"
            class="grid min-w-0 gap-4 lg:grid-cols-[1fr_1.25fr] lg:gap-6"
        >
            <SectionCard class="min-w-0">
                <template #header>
                    <div class="flex items-center gap-3">
                        <span
                            class="flex size-10 shrink-0 items-center justify-center rounded-xl bg-accent text-accent-foreground"
                        >
                            <House aria-hidden="true" class="size-5" />
                        </span>
                        <h2 class="font-semibold">Your household</h2>
                    </div>
                </template>

                <template v-if="household">
                    <p class="text-xs font-medium text-muted-foreground">
                        Household number
                    </p>
                    <p class="mt-1 text-2xl font-semibold tracking-tight">
                        {{ household.householdNumber }}
                    </p>
                    <p
                        class="mt-4 flex items-center gap-2 text-sm text-muted-foreground"
                    >
                        <MapPin
                            aria-hidden="true"
                            class="size-4 shrink-0 text-primary"
                        />
                        {{ household.barangay }}
                    </p>
                </template>
                <p
                    v-else
                    class="rounded-xl bg-secondary p-4 text-sm leading-6 text-muted-foreground"
                >
                    No household record is linked to your account yet.
                </p>
            </SectionCard>

            <SectionCard>
                <template #header>
                    <div
                        class="flex min-w-0 items-center justify-between gap-4"
                    >
                        <div class="flex min-w-0 items-center gap-3">
                            <span
                                class="flex size-10 shrink-0 items-center justify-center rounded-xl bg-accent text-accent-foreground"
                            >
                                <UsersRound aria-hidden="true" class="size-5" />
                            </span>
                            <h2 class="truncate font-semibold">
                                Family Members
                            </h2>
                        </div>
                        <span
                            class="shrink-0 text-xs font-medium text-muted-foreground"
                        >
                            {{ familyMembers.length }}
                            {{
                                familyMembers.length === 1
                                    ? 'member'
                                    : 'members'
                            }}
                        </span>
                    </div>
                </template>

                <div
                    v-if="familyMembers.length"
                    role="region"
                    aria-label="Family members"
                    tabindex="0"
                    class="grid auto-cols-[calc((100%_-_3rem)_/_4)] grid-flow-col gap-4 overflow-x-auto pb-2"
                >
                    <article
                        v-for="member in familyMembers"
                        :key="member.id"
                        class="flex min-w-0 flex-col items-center gap-2 text-center"
                    >
                        <span
                            class="flex size-14 items-center justify-center rounded-full bg-accent text-accent-foreground"
                        >
                            <UserRound aria-hidden="true" class="size-8" />
                        </span>
                        <span
                            class="w-full truncate text-xs font-medium"
                            :title="member.name"
                        >
                            {{ member.name }}
                        </span>
                        <span
                            class="-mt-1 w-full truncate text-xs text-muted-foreground"
                            :title="member.relationship"
                        >
                            {{ member.relationship }}
                        </span>
                    </article>
                </div>
                <p
                    v-else
                    class="rounded-xl bg-secondary p-4 text-sm leading-6 text-muted-foreground"
                >
                    No family members have been added to this household yet.
                </p>
            </SectionCard>
        </section>
    </div>
</template>
