import AppLayout from '@/layouts/app-layout';
import { blogs, membership } from '@/routes/admin';
import { type BreadcrumbItem } from '@/types';
import { Head, usePage } from '@inertiajs/react';
import OpenFormProvider from '@/providers/OpenFormProvider';
import SectionListBlogs from '../_components/blogs/SectionListBlogs';
import { Members } from '@/types/model/members';
import DetailsMember from '../_components/members/DetailsMember';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'معلومات العضو',
        href: '',
    },
];

export default function PageUserDetails() {
    const member = usePage<{ member: Members }>().props.member;
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title={member.name} />
            <div className="flex flex-1 flex-col  px-4 md:px-4 lg:px-6">
                <div className="@container/main  flex flex-1 flex-col gap-2">
                    <div className="flex flex-col gap-4 py-4 md:gap-6 md:py-6">
                       <DetailsMember member={member} />
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}
