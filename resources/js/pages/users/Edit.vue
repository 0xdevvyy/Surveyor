<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ArrowLeft, LoaderCircle, Save } from '@lucide/vue';
import {
    show as showPersonalInformation,
    update as updatePersonalInformation,
} from '@/actions/App/Http/Controllers/PersonalInformationController';
import { Button } from '@/components/ui/button';
import SectionCard from '@/components/ui/card/SectionCard.vue';
import { FormField, Input, SelectBox } from '@/components/ui/input';

type PersonalInformation = {
    id: string;
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
        id: string;
        name: string;
    };
    personalInformation: PersonalInformation;
    genderOptions: string[];
    bloodTypeOptions: string[];
    suffixOptions: string[];
}>();

const form = useForm({
    first_name: props.personalInformation.firstName,
    middle_name: props.personalInformation.middleName ?? '',
    last_name: props.personalInformation.lastName,
    suffix: props.personalInformation.suffix ?? '',
    blood_type: props.personalInformation.bloodType ?? '',
    gender: props.personalInformation.gender,
    age: props.personalInformation.age,
    birthdate: props.personalInformation.birthdate,
    phone_number: props.personalInformation.phoneNumber,
    email: props.personalInformation.email,
});

function submit(): void {
    form.put(updatePersonalInformation.url(props.personalInformation.id), {
        preserveScroll: true,
    });
}

function displayGender(gender: string): string {
    return gender.charAt(0).toUpperCase() + gender.slice(1);
}
</script>

<template>
    <Head :title="`Edit personal information — ${props.user.name}`" />

    <main class="mx-auto grid w-full max-w-5xl gap-6 p-4 sm:p-8">
        <header class="grid gap-4">
            <Link
                :href="showPersonalInformation(props.user.id)"
                class="inline-flex w-fit items-center gap-2 rounded-md text-sm font-medium text-muted-foreground transition-colors hover:text-foreground focus-visible:ring-2 focus-visible:ring-ring focus-visible:outline-none"
            >
                <ArrowLeft aria-hidden="true" class="size-4" />
                Back to personal information
            </Link>
            <div class="grid gap-2">
                <h1 class="text-2xl font-semibold tracking-tight sm:text-3xl">
                    Edit personal information
                </h1>
                <p class="text-sm text-muted-foreground">
                    Update personal details for {{ props.user.name }}. Household
                    and barangay records are managed separately.
                </p>
            </div>
        </header>

        <SectionCard title="Personal details">
            <form class="grid gap-6" @submit.prevent="submit">
                <div class="grid gap-5 sm:grid-cols-2">
                    <FormField
                        label="First name"
                        :error="form.errors.first_name"
                        required
                        v-slot="{ id }"
                    >
                        <Input
                            :id="id"
                            v-model="form.first_name"
                            autocomplete="given-name"
                        />
                    </FormField>

                    <FormField
                        label="Middle name"
                        :error="form.errors.middle_name"
                        v-slot="{ id }"
                    >
                        <Input
                            :id="id"
                            v-model="form.middle_name"
                            autocomplete="additional-name"
                        />
                    </FormField>

                    <FormField
                        label="Last name"
                        :error="form.errors.last_name"
                        required
                        v-slot="{ id }"
                    >
                        <Input
                            :id="id"
                            v-model="form.last_name"
                            autocomplete="family-name"
                        />
                    </FormField>

                    <FormField
                        label="Suffix"
                        :error="form.errors.suffix"
                        v-slot="{ id }"
                    >
                        <SelectBox :id="id" v-model="form.suffix">
                            <option value="">None</option>
                            <option
                                v-for="suffix in props.suffixOptions"
                                :key="suffix"
                                :value="suffix"
                            >
                                {{ suffix }}
                            </option>
                        </SelectBox>
                    </FormField>

                    <FormField
                        label="Gender"
                        :error="form.errors.gender"
                        required
                        v-slot="{ id }"
                    >
                        <SelectBox :id="id" v-model="form.gender">
                            <option
                                v-for="gender in props.genderOptions"
                                :key="gender"
                                :value="gender"
                            >
                                {{ displayGender(gender) }}
                            </option>
                        </SelectBox>
                    </FormField>

                    <FormField
                        label="Age"
                        :error="form.errors.age"
                        required
                        v-slot="{ id }"
                    >
                        <Input
                            :id="id"
                            v-model.number="form.age"
                            type="number"
                            min="0"
                            max="150"
                            inputmode="numeric"
                        />
                    </FormField>

                    <FormField
                        label="Birthdate"
                        :error="form.errors.birthdate"
                        required
                        v-slot="{ id }"
                    >
                        <Input
                            :id="id"
                            v-model="form.birthdate"
                            type="date"
                            autocomplete="bday"
                        />
                    </FormField>

                    <FormField
                        label="Blood type"
                        :error="form.errors.blood_type"
                        v-slot="{ id }"
                    >
                        <SelectBox :id="id" v-model="form.blood_type">
                            <option value="">Not specified</option>
                            <option
                                v-for="bloodType in props.bloodTypeOptions"
                                :key="bloodType"
                                :value="bloodType"
                            >
                                {{ bloodType }}
                            </option>
                        </SelectBox>
                    </FormField>

                    <FormField
                        label="Email"
                        :error="form.errors.email"
                        required
                        v-slot="{ id }"
                    >
                        <Input
                            :id="id"
                            v-model="form.email"
                            type="email"
                            autocomplete="email"
                        />
                    </FormField>

                    <FormField
                        label="Phone number"
                        :error="form.errors.phone_number"
                        required
                        v-slot="{ id }"
                    >
                        <Input
                            :id="id"
                            v-model="form.phone_number"
                            type="tel"
                            autocomplete="tel"
                        />
                    </FormField>
                </div>

                <div
                    class="flex flex-col-reverse gap-3 border-t border-border pt-5 sm:flex-row sm:justify-end"
                >
                    <Link
                        :href="showPersonalInformation(props.user.id)"
                        class="inline-flex h-10 items-center justify-center rounded-md border border-input bg-background px-4 py-2 text-sm font-medium transition-colors hover:bg-accent hover:text-accent-foreground"
                    >
                        Cancel
                    </Link>
                    <Button type="submit" :disabled="form.processing">
                        <LoaderCircle
                            v-if="form.processing"
                            aria-hidden="true"
                            class="size-4 animate-spin"
                        />
                        <Save v-else aria-hidden="true" class="size-4" />
                        {{ form.processing ? 'Saving...' : 'Save changes' }}
                    </Button>
                </div>
            </form>
        </SectionCard>
    </main>
</template>
