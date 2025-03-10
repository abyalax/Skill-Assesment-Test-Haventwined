import { Config } from 'ziggy-js';

export interface User {
    id: number;
    name: string;
    email: string;
    email_verified_at: string;
    role: string;
}

export type PageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
    auth: {
        user: User;
    };
    ziggy: Config & { location: string };
};

export interface CompanyProfile {
    id: number;
    name: string,
    whatsapp: string,
    banner: string[],
    email: string,
    description: string,
    location: string
}

export interface Event {
    id: number,
    name: string,
    content: string,
    category: string,
    theme: string,
    registration_start: string,
    registration_end: string,
    event_start: string,
    event_end: string,
    time: string,
    estimated_visitors: Number,
    location: string,
    city: string,
    url: string,
    detailed_location: string,
    company_profile_id: string,
    created_at: Date,
    updated_at: Date
}

export interface EventPagination {
    current_page: number;
    data: Array<Event>;
    first_page_url: string;
    from: number;
    last_page: number;
    last_page_url: string;
    links: Array<{url: string, label: string, active: boolean}>;
    next_page_url: string;
    path: string;
    per_page: number;
    prev_page_url: string;
    to: number;
    total: number;
}

export interface UploadWidgetOptions {
    cloudName: string;
    uploadPreset: string;
    multiple?: boolean;
    folder?: string;
    maxFiles?: number;
}

export interface UploadWidgetInstance {
    open: () => void;
}

export type UploadWidgetCallback = (error: any, result: UploadWidgetResult) => void;

export interface UploadWidgetResult {
    event: string;
    info: {
        secure_url: string;
    };
}
