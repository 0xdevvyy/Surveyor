const SIDEBAR_STORAGE_KEY = 'sidebar-collapsed';

export function getSidebarCollapsed(): boolean {
    if (typeof window === 'undefined') {
        return false;
    }

    try {
        return window.localStorage.getItem(SIDEBAR_STORAGE_KEY) === 'true';
    } catch (error) {
        console.warn('Unable to read the saved sidebar preference.', error);

        return false;
    }
}

export function setSidebarCollapsed(collapsed: boolean): void {
    if (typeof window === 'undefined') {
        return;
    }

    try {
        window.localStorage.setItem(SIDEBAR_STORAGE_KEY, String(collapsed));
    } catch (error) {
        console.warn('Unable to save the sidebar preference.', error);
    }
}
