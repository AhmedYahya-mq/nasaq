import { type BreadcrumbItem, type SharedData } from '@/types';
import { Head, usePage } from '@inertiajs/react';

import AppLayout from '@/layouts/app-layout';
import SettingsLayout from '@/layouts/settings/layout';
import TwoFactorAuth from '../_components/settings/security/2fa/TwoFactorAuth';
import { security } from '@/routes/admin';
import { type SecurityProps } from '@/types/shared/auth';
import SessionsContainer from '../_components/settings/security/sessions/SessionsContainer';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'إعدادات الأمان',
        href: security().url,
    },
];

export default function Security({ status, sessions }:SecurityProps) {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="إعدادات الأمان" />
            <SettingsLayout>
                <TwoFactorAuth status={status} />
                <SessionsContainer sessions={sessions} />
            </SettingsLayout>
        </AppLayout>
    );
}
