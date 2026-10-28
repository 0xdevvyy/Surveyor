export type User = {
    id: string;
    name: string;
    email: string;
    role: string;
    avatar_path: string;
    email_verified_at: string | null;
    created_at: string;
    updated_at: string;
    [key: string]: unknown;
};

export type Auth = {
    user: User;
};

// export type UserRole = 'admin' | 'surveyor' | 'resident';
