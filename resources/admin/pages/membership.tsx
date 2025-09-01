import AppLayout from '@/layouts/app-layout';
import { membership } from '@/routes/admin';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/react';
import SectionListOrder from './_components/memberships/SectionListMembership';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'العضويات',
        href: membership().url,
    },
];

export default function Product() {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="العضويات" />
            <div className="flex flex-1 flex-col  px-4 md:px-4 lg:px-6">
                <div className="@container/main  flex flex-1 flex-col gap-2">
                    <div className="flex flex-col gap-4 py-4 md:gap-6 md:py-6">
                        <SectionListOrder />
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}
