import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/react';
import OpenFormProvider from '@/providers/OpenFormProvider';
import { library } from '@/routes/admin';
import SectionLisLibrarys from '../_components/library/SectionLisLibrarys';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'المكتبة',
        href: library().url,
    },
];

export default function PageLibrary() {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="المكتبة" />
            <div className="flex flex-1 flex-col  px-4 md:px-4 lg:px-6">
                <div className="@container/main  flex flex-1 flex-col gap-2">
                    <div className="flex flex-col gap-4 py-4 md:gap-6 md:py-6">
                        <OpenFormProvider>
                           <SectionLisLibrarys />
                        </OpenFormProvider>
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}
