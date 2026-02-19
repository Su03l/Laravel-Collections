import { AxiosInstance } from 'axios';
import { PageProps as InertiaPageProps } from '@inertiajs/core';
import { Page } from '@inertiajs/core';

declare global {
    interface Window {
        axios: AxiosInstance;
    }

    var route: any;
}

declare module '@inertiajs/core' {
    interface PageProps extends InertiaPageProps, Page<PageProps> {
        auth: {
            user: {
                id: number;
                name: string;
                email: string;
                email_verified_at: string | null;
            } | null;
        };
        [key: string]: any;
    }
}
