import {
    adminDashboard,
    residentDashboard,
    surveyorDashboard,
} from '@/actions/App/Http/Controllers/DashboardController';
import { LayoutDashboard } from '@lucide/vue';
import type { Component } from 'vue';

export interface NavChild {
    label: string;
    href: string | { url: string };
}

export interface NavItem {
    label: string;
    icon: Component;
    type: 'link' | 'dropdown';
    href?: string | { url: string };
    children?: NavChild[];
}

export function getNavItems(role?: string): NavItem[] {
    switch (role?.trim().toLowerCase()) {
        case 'admin':
            return [
                {
                    label: 'Dashboard',
                    icon: LayoutDashboard,
                    type: 'link',
                    href: adminDashboard(),
                },
            ];

        case 'surveyor':
            return [
                {
                    label: 'Dashboard',
                    icon: LayoutDashboard,
                    type: 'link',
                    href: surveyorDashboard(),
                },
            ];

        case 'resident':
            return [
                {
                    label: 'Dashboard',
                    icon: LayoutDashboard,
                    type: 'link',
                    href: residentDashboard(),
                },
            ];

        default:
            return [];
    }
}
