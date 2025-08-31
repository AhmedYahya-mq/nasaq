

import { type BreadcrumbItem, type SharedData } from '@/types';
import { Head, usePage } from '@inertiajs/react';

import AppLayout from '@/layouts/app-layout';
import SettingsLayout from '@/layouts/settings/layout';
import TwoFactorAuth from '../_components/settings/security/2fa/TwoFactorAuth';
import { security } from '@/routes/admin';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Security settings',
        href: security().url,
    },
];

export default function Security({ status }: { status?: string }) {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Security settings" />
            <SettingsLayout>
                <TwoFactorAuth status={status} />
            </SettingsLayout>
        </AppLayout>
    );
}
