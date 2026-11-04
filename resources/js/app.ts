import { createInertiaApp } from '@inertiajs/vue3';
import AppLayout from '@/components/layouts/AppLayout.vue';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

void createInertiaApp({
    title: (title) => (title ? `${title} - ${appName}` : appName),
    layout: (name) => {
        switch (true) {
            case name === 'Welcome':
            case name.startsWith('auth/'):
            case name === 'dashboard/Surveyor':
            case name === 'dashboard/Resident':
                return null;
            default:
                return AppLayout;
        }
    },
    withApp: (app) => {
        app.directive('focus', {
            mounted: (el: HTMLElement, shouldFocus) => {
                if (shouldFocus.value !== false) {
                    el.focus();
                }
            },
        });
    },

    progress: {
        color: '#4B5563',
    },
});
