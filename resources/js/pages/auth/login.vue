<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import { LoaderCircle, MapPin } from '@lucide/vue';
import { home } from '@/routes';
import { Button } from '@/components/ui/button';
import { Checkbox, Input, Label, PasswordInput } from '@/components/ui/input';

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

function submit(): void {
    form.post('/login', {
        onSuccess: () => form.reset('password'),
    });
}
</script>

<template>
    <Head title="Log in" />

    <main
        class="grid min-h-screen bg-background text-foreground lg:grid-cols-[minmax(0,1.05fr)_minmax(28rem,0.95fr)]"
    >
        <section
            class="relative hidden min-h-screen overflow-hidden bg-capas-navy px-12 py-10 text-white lg:flex lg:flex-col xl:px-20"
        >
            <div
                class="pointer-events-none absolute -top-40 -left-40 size-[34rem] rounded-full border border-white/10"
            />
            <div
                class="pointer-events-none absolute -top-24 -left-24 size-[25rem] rounded-full border border-white/10"
            />
            <div
                class="pointer-events-none absolute -top-8 -left-8 size-[16rem] rounded-full border border-white/10"
            />
            <div
                class="pointer-events-none absolute right-[-8rem] bottom-[-8rem] size-[28rem] rounded-full bg-crater-teal/30 blur-3xl"
            />

            <Link
                :href="home()"
                class="relative z-10 inline-flex w-fit items-center gap-3 rounded-sm transition-opacity hover:opacity-80 focus-visible:ring-2 focus-visible:ring-white focus-visible:outline-none"
                aria-label="Surveyor home"
            >
                <span
                    class="flex size-11 items-center justify-center rounded-xl bg-white/10 text-lake-mist ring-1 ring-white/15"
                >
                    <MapPin
                        aria-hidden="true"
                        class="size-6"
                        :stroke-width="1.7"
                    />
                </span>
                <span class="text-xl font-semibold tracking-wide"
                    >Surveyor</span
                >
            </Link>

            <div
                class="relative z-10 flex max-w-xl flex-1 flex-col justify-center gap-6"
            >
                <h1
                    class="text-5xl leading-[1.12] font-semibold tracking-tight xl:text-6xl"
                >
                    Helping people to Survey Better.
                    <span class="block text-lake-mist"
                        >Better Data, Better Life.</span
                    >
                </h1>
                <p class="max-w-lg text-lg leading-8 text-white/70">
                    A thoughtful way to understand local needs, bring people
                    together, and make every response count.
                </p>
            </div>
        </section>

        <section
            class="flex min-h-screen flex-col justify-center px-6 py-12 sm:px-10 lg:px-14 xl:px-24"
        >
            <div class="mx-auto w-full max-w-md">
                <div class="mb-10 flex items-center gap-3 lg:hidden">
                    <span
                        class="flex size-10 items-center justify-center rounded-xl bg-capas-navy text-lake-mist"
                    >
                        <MapPin
                            aria-hidden="true"
                            class="size-5"
                            :stroke-width="1.7"
                        />
                    </span>
                    <span class="text-lg font-semibold tracking-wide"
                        >Surveyor</span
                    >
                </div>

                <div class="mb-8 space-y-3">
                    <p
                        class="text-sm font-semibold tracking-[0.14em] text-crater-teal uppercase"
                    >
                        Welcome back
                    </p>
                    <h2
                        class="text-3xl font-semibold tracking-tight sm:text-4xl"
                    >
                        Sign in to your account
                    </h2>
                    <p class="text-muted-foreground">
                        Enter your account info to continue to Surveyor.
                    </p>
                </div>

                <form class="space-y-5" @submit.prevent="submit">
                    <div class="space-y-2">
                        <Label for="email" class="text-sm font-medium">
                            Email address
                        </Label>
                        <Input
                            id="email"
                            v-model="form.email"
                            name="email"
                            type="email"
                            autocomplete="email"
                            placeholder="you@example.com"
                            required
                            autofocus
                            :aria-invalid="Boolean(form.errors.email)"
                            :aria-describedby="
                                form.errors.email ? 'email-error' : undefined
                            "
                            class="h-12 rounded-lg bg-card px-4 shadow-sm focus-visible:ring-ring/20"
                            :class="
                                form.errors.email
                                    ? 'border-destructive focus-visible:border-destructive focus-visible:ring-destructive/20'
                                    : ''
                            "
                        />
                        <p
                            v-if="form.errors.email"
                            id="email-error"
                            class="text-sm text-destructive"
                        >
                            {{ form.errors.email }}
                        </p>
                    </div>

                    <div class="space-y-2">
                        <Label for="password" class="text-sm font-medium">
                            Password
                        </Label>
                        <PasswordInput
                            id="password"
                            v-model="form.password"
                            name="password"
                            autocomplete="current-password"
                            placeholder="Enter your password"
                            required
                            :aria-invalid="Boolean(form.errors.password)"
                            :aria-describedby="
                                form.errors.password
                                    ? 'password-error'
                                    : undefined
                            "
                            class="h-12 rounded-lg bg-card px-4 shadow-sm focus-visible:ring-ring/20"
                            :class="
                                form.errors.password
                                    ? 'border-destructive focus-visible:border-destructive focus-visible:ring-destructive/20'
                                    : ''
                            "
                        />
                        <p
                            v-if="form.errors.password"
                            id="password-error"
                            class="text-sm text-destructive"
                        >
                            {{ form.errors.password }}
                        </p>
                    </div>

                    <div class="flex items-center gap-2.5">
                        <Checkbox
                            id="remember"
                            v-model="form.remember"
                            name="remember"
                        />
                        <Label
                            for="remember"
                            class="cursor-pointer text-sm text-muted-foreground transition-colors hover:text-foreground"
                        >
                            Remember me
                        </Label>
                    </div>

                    <Button
                        type="submit"
                        size="lg"
                        :disabled="form.processing"
                        class="w-full rounded-lg transition-[transform,box-shadow] hover:shadow-md active:scale-[0.99]"
                    >
                        <LoaderCircle
                            v-if="form.processing"
                            aria-hidden="true"
                            class="size-4 animate-spin"
                        />
                        {{ form.processing ? 'Signing in...' : 'Sign in' }}
                    </Button>
                </form>

                <p class="mt-8 text-center text-sm text-muted-foreground">
                    Need help accessing your account?
                    <span class="font-medium text-foreground">
                        Contact your administrator.
                    </span>
                </p>
            </div>

            <p
                class="mx-auto mt-12 w-full max-w-md text-center text-xs text-muted-foreground/80"
            >
                Secure access for your community survey workspace
            </p>
        </section>
    </main>
</template>
