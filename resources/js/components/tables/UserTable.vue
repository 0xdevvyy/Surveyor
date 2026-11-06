<script setup lang="ts">
import { Link, router } from '@inertiajs/vue3';
import { Eye, Pencil } from '@lucide/vue';
import { adminDashboard } from '@/actions/App/Http/Controllers/DashboardController';
import {
    edit as personalInformationEdit,
    show as personalInformationShow,
} from '@/actions/App/Http/Controllers/PersonalInformationController';
import Avatar from '@/components/ui/data-display/Avatar.vue';
import Pagination from '@/components/ui/data-display/Pagination.vue';
import Badge from '@/components/ui/data-display/Badge.vue';
import EmptyState from '@/components/ui/empty-state/EmptyState.vue';
import IconButton from '@/components/ui/button/IconButton.vue';
import Table from '@/components/ui/table/Table.vue';
import TableBody from '@/components/ui/table/TableBody.vue';
import TableCell from '@/components/ui/table/TableCell.vue';
import TableHead from '@/components/ui/table/TableHead.vue';
import TableHeader from '@/components/ui/table/TableHeader.vue';
import TableRow from '@/components/ui/table/TableRow.vue';
import DeleteUserDialog from '@/components/tables/DeleteUserDialog.vue';
import type { PaginatedUsers } from '@/types/auth';

const props = defineProps<{
    users: PaginatedUsers;
    currentUserId: string;
    title?: string;
    paginationUrl?: (page: number) => string;
}>();

function formatDate(date: string): string {
    const parsedDate = new Date(date);

    if (Number.isNaN(parsedDate.getTime())) {
        return '—';
    }

    return new Intl.DateTimeFormat('en', {
        dateStyle: 'medium',
    }).format(parsedDate);
}

function visitPage(page: number): void {
    router.get(
        props.paginationUrl?.(page) ?? adminDashboard.url({ query: { page } }),
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
    <section
        aria-labelledby="users-table-heading"
        class="overflow-hidden rounded-xl border border-border bg-card"
    >
        <div
            class="flex flex-col gap-1 border-b border-border px-4 py-4 sm:px-6"
        >
            <h2 id="users-table-heading" class="text-base font-semibold">
                {{ props.title ?? 'Recent users' }}
            </h2>
            <p class="text-sm text-muted-foreground">
                {{ users.total }}
                {{ users.total === 1 ? 'account' : 'accounts' }}
            </p>
        </div>

        <EmptyState
            v-if="users.data.length === 0"
            title="No users yet"
            description="Registered users will appear here."
            class="m-4 sm:m-6"
        />

        <Table v-else>
            <TableHeader>
                <TableRow>
                    <TableHead>User</TableHead>
                    <TableHead>Email</TableHead>
                    <TableHead>Role</TableHead>
                    <TableHead>Barangay / house number</TableHead>
                    <TableHead>Account status</TableHead>
                    <TableHead class="text-right">Joined</TableHead>
                    <TableHead class="text-right">Actions</TableHead>
                </TableRow>
            </TableHeader>
            <TableBody>
                <TableRow v-for="user in users.data" :key="user.id">
                    <TableCell>
                        <div class="flex min-w-48 items-center gap-3">
                            <Avatar
                                :src="user.avatarPath ?? undefined"
                                :name="user.name"
                                class="size-9"
                            />
                            <span class="font-medium text-foreground">
                                {{ user.name }}
                            </span>
                        </div>
                    </TableCell>
                    <TableCell class="text-muted-foreground">
                        {{ user.email }}
                    </TableCell>
                    <TableCell>
                        <Badge
                            :variant="
                                user.role === 'admin'
                                    ? 'default'
                                    : user.role === 'surveyor'
                                      ? 'info'
                                      : 'secondary'
                            "
                        >
                            {{ user.role }}
                        </Badge>
                    </TableCell>
                    <TableCell>
                        <ul
                            v-if="user.households?.length"
                            class="grid gap-1 text-sm"
                        >
                            <li
                                v-for="household in user.households"
                                :key="`${household.barangay}-${household.householdNumber}`"
                            >
                                <span class="font-medium text-foreground">
                                    {{ household.barangay }}
                                </span>
                                <span class="text-muted-foreground">
                                    · {{ household.householdNumber }}
                                </span>
                            </li>
                        </ul>
                        <span v-else class="text-muted-foreground">—</span>
                    </TableCell>
                    <TableCell>
                        <Badge
                            :variant="
                                user.emailVerifiedAt ? 'success' : 'warning'
                            "
                        >
                            {{ user.emailVerifiedAt ? 'Verified' : 'Pending' }}
                        </Badge>
                    </TableCell>
                    <TableCell
                        class="text-right whitespace-nowrap text-muted-foreground"
                    >
                        {{ formatDate(user.createdAt) }}
                    </TableCell>
                    <TableCell>
                        <div class="flex justify-end gap-1">
                            <Link
                                v-if="user.hasPersonalInformation"
                                :href="personalInformationShow.url(user.id)"
                                :aria-label="`View ${user.name}'s personal information`"
                                :title="`View ${user.name}'s personal information`"
                                class="inline-flex size-10 shrink-0 items-center justify-center rounded-md transition-colors hover:bg-accent hover:text-accent-foreground focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 focus-visible:outline-none"
                            >
                                <Eye aria-hidden="true" class="size-4" />
                            </Link>
                            <IconButton
                                v-else
                                label="Personal information is unavailable"
                                disabled
                            >
                                <Eye aria-hidden="true" class="size-4" />
                            </IconButton>
                            <Link
                                v-if="user.personalInformationId"
                                :href="
                                    personalInformationEdit.url(
                                        user.personalInformationId,
                                    )
                                "
                                :aria-label="`Edit ${user.name}'s personal information`"
                                :title="`Edit ${user.name}'s personal information`"
                                class="inline-flex size-10 shrink-0 items-center justify-center rounded-md transition-colors hover:bg-accent hover:text-accent-foreground focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 focus-visible:outline-none"
                            >
                                <Pencil aria-hidden="true" class="size-4" />
                            </Link>
                            <IconButton
                                v-else
                                label="Personal information is unavailable"
                                disabled
                            >
                                <Pencil aria-hidden="true" class="size-4" />
                            </IconButton>
                            <DeleteUserDialog
                                :user="user"
                                :disabled="user.id === currentUserId"
                            />
                        </div>
                    </TableCell>
                </TableRow>
            </TableBody>
        </Table>

        <div
            v-if="users.data.length > 0"
            class="flex flex-col items-center justify-between gap-3 border-t border-border px-4 py-3 sm:flex-row sm:px-6"
        >
            <p class="text-sm text-muted-foreground">
                Showing {{ users.from }}–{{ users.to }} of {{ users.total }}
                accounts
            </p>
            <Pagination
                v-if="users.last_page > 1"
                :model-value="users.current_page"
                :total-pages="users.last_page"
                label="Users pages"
                @update:model-value="visitPage"
            />
        </div>
    </section>
</template>
