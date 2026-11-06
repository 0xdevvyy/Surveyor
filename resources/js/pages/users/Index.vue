<script setup lang="ts">
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import { Search } from '@lucide/vue';
import { index as usersIndex } from '@/actions/App/Http/Controllers/UserController';
import UserTable from '@/components/tables/UserTable.vue';
import type { PaginatedUsers } from '@/types/auth';
import { ref } from 'vue';

type UserRoleFilter = 'surveyor' | 'resident' | null;

const props = defineProps<{
    users: PaginatedUsers;
    filters: {
        role: UserRoleFilter;
        search: string | null;
    };
}>();

const currentUserId = usePage().props.auth.user.id;
const search = ref(props.filters.search ?? '');

const roleFilters: {
    label: string;
    role: UserRoleFilter;
}[] = [
    { label: 'All users', role: null },
    { label: 'Surveyors', role: 'surveyor' },
    { label: 'Residents', role: 'resident' },
];

function usersPageUrl(page: number): string {
    return usersIndex.url({
        query: {
            ...(props.filters.role ? { role: props.filters.role } : {}),
            ...(props.filters.search ? { search: props.filters.search } : {}),
            page,
        },
    });
}

function filteredUsersUrl(role: UserRoleFilter): string {
    return usersIndex.url({
        query: {
            ...(role ? { role } : {}),
            ...(props.filters.search ? { search: props.filters.search } : {}),
        },
    });
}

function searchUsers(): void {
    const searchTerm = search.value.trim();

    router.get(
        usersIndex.url({
            query: {
                ...(props.filters.role ? { role: props.filters.role } : {}),
                ...(searchTerm ? { search: searchTerm } : {}),
            },
        }),
        {},
        {
            preserveScroll: true,
            preserveState: true,
            replace: true,
        },
    );
}
</script>

<template>
    <Head title="Users" />

    <main class="mx-auto w-full max-w-7xl p-4 sm:p-8">
        <header class="mb-6 flex flex-col gap-4 sm:mb-8">
            <div>
                <p class="text-sm font-medium text-crater-teal">
                    Admin workspace
                </p>
                <h1
                    class="mt-2 text-2xl font-semibold tracking-tight sm:text-3xl"
                >
                    Users
                </h1>
                <p class="mt-2 text-sm text-muted-foreground">
                    Browse surveyors and residents registered on the platform.
                </p>
            </div>

            <div
                class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between"
            >
                <form
                    class="flex w-full max-w-xl gap-2"
                    role="search"
                    @submit.prevent="searchUsers"
                >
                    <label class="sr-only" for="user-search">
                        Search users by name, barangay, or house number
                    </label>
                    <input
                        id="user-search"
                        v-model="search"
                        type="search"
                        maxlength="100"
                        placeholder="Search name, barangay, or house number"
                        class="h-10 min-w-0 flex-1 rounded-md border border-input bg-background px-3 text-sm text-foreground placeholder:text-muted-foreground focus-visible:ring-2 focus-visible:ring-ring focus-visible:outline-none"
                    />
                    <button
                        type="submit"
                        class="inline-flex h-10 items-center justify-center gap-2 rounded-md bg-primary px-4 text-sm font-medium text-primary-foreground transition-colors hover:bg-primary/90"
                    >
                        <Search aria-hidden="true" class="size-4" />
                        Search
                    </button>
                </form>

                <nav
                    aria-label="Filter users by role"
                    class="flex flex-wrap gap-2"
                >
                    <Link
                        v-for="filter in roleFilters"
                        :key="filter.label"
                        :href="filteredUsersUrl(filter.role)"
                        :aria-current="
                            props.filters.role === filter.role
                                ? 'page'
                                : undefined
                        "
                        :class="
                            props.filters.role === filter.role
                                ? 'bg-primary text-primary-foreground'
                                : 'border border-input bg-background text-foreground hover:bg-accent'
                        "
                        class="inline-flex min-h-10 items-center justify-center rounded-md px-4 py-2 text-sm font-medium transition-colors"
                    >
                        {{ filter.label }}
                    </Link>
                </nav>
            </div>
        </header>

        <UserTable
            :users="props.users"
            :current-user-id="currentUserId"
            :title="
                props.filters.role
                    ? `${props.filters.role} accounts`
                    : 'All accounts'
            "
            :pagination-url="usersPageUrl"
        />
    </main>
</template>
