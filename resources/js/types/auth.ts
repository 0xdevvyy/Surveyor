export type User = {
    id: string;
    name: string;
    email: string;
    role: string;
    avatar_path?: string | null;
    email_verified_at?: string | null;
    created_at?: string;
    hasPersonalInformation?: boolean;
    avatarPath?: string | null;
    emailVerifiedAt: string | null;
    createdAt: string;
    households?: {
        householdNumber: string;
        barangay: string;
    }[];
    updated_at?: string;
    [key: string]: unknown;
};

export type PaginatedUsers = {
    data: User[];
    current_page: number;
    last_page: number;
    per_page: number;
    total: number;
    from: number | null;
    to: number | null;
};

export type Auth = {
    user: User;
};

// export type UserRole = 'admin' | 'surveyor' | 'resident';
