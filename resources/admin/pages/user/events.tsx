import AppLayout from '@/layouts/app-layout';
import { blogs, events, membership } from '@/routes/admin';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/react';
import OpenFormProvider from '@/providers/OpenFormProvider';
import SectionListEvents from '../_components/events/SectionListEvents';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'الفعاليات',
        href: events().url,
    },
];

export default function PageEvents() {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="الفعاليات" />
            <div className="flex flex-1 flex-col  px-4 md:px-4 lg:px-6">
                <div className="@container/main  flex flex-1 flex-col gap-2">
                    <div className="flex flex-col gap-4 py-4 md:gap-6 md:py-6">
                        <OpenFormProvider>
                            <SectionListEvents />
                        </OpenFormProvider>
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}
