<script setup lang="ts">
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';
import { Trash2 } from '@lucide/vue';
import { destroy as deleteUser } from '@/actions/App/Http/Controllers/UserController';
import Button from '@/components/ui/button/Button.vue';
import IconButton from '@/components/ui/button/IconButton.vue';
import Dialog from '@/components/ui/dialog/Dialog.vue';
import DialogContent from '@/components/ui/dialog/DialogContent.vue';
import DialogDescription from '@/components/ui/dialog/DialogDescription.vue';
import DialogFooter from '@/components/ui/dialog/DialogFooter.vue';
import DialogHeader from '@/components/ui/dialog/DialogHeader.vue';
import DialogTitle from '@/components/ui/dialog/DialogTitle.vue';
import type { User } from '@/types/auth';

const props = defineProps<{
    user: User;
    disabled?: boolean;
}>();

const isOpen = ref(false);
const isDeleting = ref(false);

function deleteUserAccount(): void {
    isDeleting.value = true;

    router.delete(deleteUser(props.user.id).url, {
        preserveScroll: true,
        onSuccess: () => {
            isOpen.value = false;
        },
        onFinish: () => {
            isDeleting.value = false;
        },
    });
}
</script>

<template>
    <div class="contents">
        <IconButton
            :label="
                disabled
                    ? 'You cannot delete your own account'
                    : `Delete ${user.name}`
            "
            :disabled="disabled"
            @click="isOpen = true"
        >
            <Trash2 aria-hidden="true" class="size-4" />
        </IconButton>

        <Dialog
            v-model="isOpen"
            :label="`Delete ${user.name}`"
            close-label="Cancel delete user"
        >
            <DialogContent>
                <DialogHeader>
                    <DialogTitle>Delete {{ user.name }}?</DialogTitle>
                    <DialogDescription>
                        This permanently deletes the account and its associated
                        household, personal information, and survey records.
                        This action cannot be undone.
                    </DialogDescription>
                </DialogHeader>

                <DialogFooter>
                    <Button
                        variant="outline"
                        :disabled="isDeleting"
                        @click="isOpen = false"
                    >
                        Cancel
                    </Button>
                    <Button
                        variant="destructive"
                        :disabled="isDeleting"
                        @click="deleteUserAccount"
                    >
                        {{ isDeleting ? 'Deleting...' : 'Delete account' }}
                    </Button>
                </DialogFooter>
            </DialogContent>
        </Dialog>
    </div>
</template>
