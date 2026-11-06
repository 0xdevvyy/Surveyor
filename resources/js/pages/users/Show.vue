<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { ArrowLeft, ContactRound, House, MapPin, UserRound } from '@lucide/vue';
import SectionCard from '@/components/ui/card/SectionCard.vue';

type PersonalInformation = {
    firstName: string;
    middleName: string | null;
    lastName: string;
    suffix: string | null;
    bloodType: string | null;
    gender: string;
    age: number;
    birthdate: string;
    phoneNumber: string;
    email: string;
};

const props = defineProps<{
    user: {
        name: string;
        role: string;
    };
    personalInformation: PersonalInformation;
    households: {
        id: string;
        householdNumber: string;
        barangay: string;
    }[];
    backUrl: string;
}>();

function displayValue(value: string | null): string {
    return value?.trim() || '—';
}

function formatBirthdate(birthdate: string): string {
    return new Intl.DateTimeFormat('en-PH', {
        dateStyle: 'long',
    }).format(new Date(`${birthdate}T00:00:00`));
}
</script>

<template>
    <Head :title="`${props.user.name} — Personal information`" />

    <main class="mx-auto grid w-full max-w-5xl gap-6 p-4 sm:p-8">
        <header class="grid gap-4">
            <Link
                :href="props.backUrl"
                class="inline-flex w-fit items-center gap-2 rounded-md text-sm font-medium text-muted-foreground transition-colors hover:text-foreground focus-visible:ring-2 focus-visible:ring-ring focus-visible:outline-none"
            >
                <ArrowLeft aria-hidden="true" class="size-4" />
                Back
            </Link>

            <div>
                <p class="text-sm font-medium text-crater-teal">
                    {{ props.user.role }} account
                </p>
                <h1
                    class="mt-2 text-2xl font-semibold tracking-tight sm:text-3xl"
                >
                    {{ props.user.name }}
                </h1>
                <p class="mt-2 text-sm text-muted-foreground">
                    Personal information on file for this user.
                </p>
            </div>
        </header>

        <div class="grid gap-6 lg:grid-cols-2">
            <SectionCard>
                <template #header>
                    <div class="flex items-center gap-3">
                        <span
                            class="flex size-10 shrink-0 items-center justify-center rounded-xl bg-accent text-accent-foreground"
                        >
                            <UserRound aria-hidden="true" class="size-5" />
                        </span>
                        <div>
                            <h2 class="font-semibold">Personal details</h2>
                            <p class="text-sm text-muted-foreground">
                                Identity and demographic information
                            </p>
                        </div>
                    </div>
                </template>

                <dl class="grid gap-4 sm:grid-cols-2">
                    <div class="grid gap-1">
                        <dt class="text-sm text-muted-foreground">
                            First name
                        </dt>
                        <dd class="font-medium">
                            {{ props.personalInformation.firstName }}
                        </dd>
                    </div>
                    <div class="grid gap-1">
                        <dt class="text-sm text-muted-foreground">
                            Middle name
                        </dt>
                        <dd class="font-medium">
                            {{
                                displayValue(
                                    props.personalInformation.middleName,
                                )
                            }}
                        </dd>
                    </div>
                    <div class="grid gap-1">
                        <dt class="text-sm text-muted-foreground">Last name</dt>
                        <dd class="font-medium">
                            {{ props.personalInformation.lastName }}
                        </dd>
                    </div>
                    <div class="grid gap-1">
                        <dt class="text-sm text-muted-foreground">Suffix</dt>
                        <dd class="font-medium">
                            {{ displayValue(props.personalInformation.suffix) }}
                        </dd>
                    </div>
                    <div class="grid gap-1">
                        <dt class="text-sm text-muted-foreground">Gender</dt>
                        <dd class="font-medium">
                            {{ props.personalInformation.gender }}
                        </dd>
                    </div>
                    <div class="grid gap-1">
                        <dt class="text-sm text-muted-foreground">Age</dt>
                        <dd class="font-medium">
                            {{ props.personalInformation.age }}
                        </dd>
                    </div>
                    <div class="grid gap-1">
                        <dt class="text-sm text-muted-foreground">Birthdate</dt>
                        <dd class="font-medium">
                            {{
                                formatBirthdate(
                                    props.personalInformation.birthdate,
                                )
                            }}
                        </dd>
                    </div>
                    <div class="grid gap-1">
                        <dt class="text-sm text-muted-foreground">
                            Blood type
                        </dt>
                        <dd class="font-medium">
                            {{
                                displayValue(
                                    props.personalInformation.bloodType,
                                )
                            }}
                        </dd>
                    </div>
                </dl>
            </SectionCard>

            <SectionCard>
                <template #header>
                    <div class="flex items-center gap-3">
                        <span
                            class="flex size-10 shrink-0 items-center justify-center rounded-xl bg-accent text-accent-foreground"
                        >
                            <ContactRound aria-hidden="true" class="size-5" />
                        </span>
                        <div>
                            <h2 class="font-semibold">Contact information</h2>
                            <p class="text-sm text-muted-foreground">
                                Current email and phone number
                            </p>
                        </div>
                    </div>
                </template>

                <dl class="grid gap-4">
                    <div class="grid gap-1">
                        <dt class="text-sm text-muted-foreground">Email</dt>
                        <dd class="font-medium break-all">
                            {{ props.personalInformation.email }}
                        </dd>
                    </div>
                    <div class="grid gap-1">
                        <dt class="text-sm text-muted-foreground">
                            Phone number
                        </dt>
                        <dd class="font-medium">
                            {{ props.personalInformation.phoneNumber }}
                        </dd>
                    </div>
                </dl>
            </SectionCard>

            <SectionCard class="lg:col-span-2">
                <template #header>
                    <div class="flex items-center gap-3">
                        <span
                            class="flex size-10 shrink-0 items-center justify-center rounded-xl bg-accent text-accent-foreground"
                        >
                            <House aria-hidden="true" class="size-5" />
                        </span>
                        <div>
                            <h2 class="font-semibold">
                                Household and barangay
                            </h2>
                            <p class="text-sm text-muted-foreground">
                                Household records linked to this user
                            </p>
                        </div>
                    </div>
                </template>

                <ul
                    v-if="props.households.length > 0"
                    class="grid gap-4 sm:grid-cols-2"
                >
                    <li
                        v-for="household in props.households"
                        :key="household.id"
                        class="grid gap-3 rounded-lg border border-border p-4 sm:grid-cols-2"
                    >
                        <div class="grid gap-1">
                            <span class="text-sm text-muted-foreground">
                                Household number
                            </span>
                            <span class="font-medium">
                                {{ household.householdNumber }}
                            </span>
                        </div>
                        <div class="grid gap-1">
                            <span
                                class="flex items-center gap-2 text-sm text-muted-foreground"
                            >
                                <MapPin
                                    aria-hidden="true"
                                    class="size-4 shrink-0"
                                />
                                Barangay
                            </span>
                            <span class="font-medium">
                                {{ household.barangay }}
                            </span>
                        </div>
                    </li>
                </ul>
                <p
                    v-else
                    class="rounded-lg bg-secondary p-4 text-sm text-muted-foreground"
                >
                    No household or barangay is linked to this user yet.
                </p>
            </SectionCard>
        </div>
    </main>
</template>
