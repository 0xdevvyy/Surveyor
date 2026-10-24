export type ThemePreference = 'dark' | 'light';

const themePreferenceKey = 'surveyor-theme';

export function getThemePreference(): ThemePreference | null {
    try {
        const preference = window.localStorage.getItem(themePreferenceKey);

        return preference === 'dark' || preference === 'light'
            ? preference
            : null;
    } catch (error) {
        console.error('Unable to read the saved theme preference.', error);

        return null;
    }
}

export function saveThemePreference(preference: ThemePreference): void {
    try {
        window.localStorage.setItem(themePreferenceKey, preference);
    } catch (error) {
        console.error('Unable to save the theme preference.', error);
    }
}
