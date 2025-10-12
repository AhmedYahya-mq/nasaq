import { Card, CardContent } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import AppLayout from '@/layouts/app-layout';
import { events } from '@/routes/admin';
import { type BreadcrumbItem } from '@/types';
import { EventModel, EventRegistration, type EventDetails } from '@/types/model/events';
import { Head } from '@inertiajs/react';
import { format } from 'date-fns';
import { ar } from 'date-fns/locale';
import { Calendar, Clock, GlobeIcon, MapPin, Search, UserCheck2Icon, Users, UserX2 } from 'lucide-react';

import { useEffect, useState } from 'react';
import axios from 'axios';
import { registrations as register } from '@/routes/admin/event';
import { AttendeeCardSkeleton } from '../_components/events/AttendeeCardSkeleton';
import { AttendeeCard } from '../_components/events/AttendeeCard';
import { toggleAttendance } from '@/routes/admin/event/registrations';
import { toast } from 'sonner';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'الفعاليات',
        href: events().url,
    },
];

export default function PageEventDetails({ event }: { event: EventDetails }) {
    const { event: even } = event as { event: EventModel };
    const [registrations, setRegistrations] = useState<EventRegistration[]>([]);
    const [pagination, setPagination] = useState<{ links: any, meta: any }>({ links: {}, meta: {} });
    const [searchTerm, setSearchTerm] = useState<string>('');
    const [isLoading, setIsLoading] = useState<boolean>(false);
    const [currentPage, setCurrentPage] = useState<number>(1);

    useEffect(() => {
        fetchRegistrations(even.id);
    }, []);

    async function fetchRegistrations(eventId: number, page: number = 1) {
        setIsLoading(true);
        try {
            const response = await axios.get(register(eventId).url, {
                params: {
                    search: searchTerm,
                    page,
                },
            });
            setRegistrations(response.data.registrations);
            setPagination(response.data);
            setCurrentPage(page);
        } catch (error) {
            console.error('Error fetching registrations:', error);
        } finally {
            setIsLoading(false);
        }
    }

    const toggleAttendanceHandler = async (registrationId: number) => {
        const toastId = toast.loading('جاري تحديث حالة الحضور...');
        try {
            const res = await axios.put(toggleAttendance(registrationId).url);
            // تحديث الحالة في الـstate
            setRegistrations((prev) =>
                prev.map((reg) =>
                    reg.id === registrationId ? res.data.registration : reg
                )
            );
        } catch (error) {
            console.error('Error updating attendance:', error);
            toast.error('حدث خطأ أثناء تحديث حالة الحضور. حاول مرة أخرى.');
        }
        toast.dismiss(toastId);
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title={even.title} />

            <div className="flex flex-1 flex-col px-4 md:px-4 lg:px-6">
                <div className="@container/main flex flex-1 flex-col gap-2">
                    {/* Header */}
                    <div className="flex flex-col gap-4 py-4 md:gap-6 md:py-6">
                        <div className="flex flex-col gap-2">
                            <div className="flex items-center justify-between">
                                <h1 className="text-xl font-bold leading-tight tracking-tighter md:text-2xl">
                                    {even.title}
                                </h1>
                                <span className={`px-3 py-1 rounded-full text-xs font-medium badget border`}
                                    style={{
                                        ["--badget-color" as any]: even.event_status?.color ?? "#6b7280",
                                        borderColor: even.event_status?.color ?? "#6b7280",
                                    }}
                                >
                                    <Calendar className="size-3.5 inline-block ml-1" />
                                    {even.event_status.label_ar}
                                </span>
                            </div>
                            <p className="text-sm text-muted-foreground">{even.description}</p>
                            <div className="flex items-center text-sm text-muted-foreground flex-wrap gap-3 md:gap-5">
                                <div className="flex items-center gap-2">
                                    <Calendar className="size-4" />
                                    <span>{even.start_at ? format(new Date(even.start_at), "d MMMM yyyy", { locale: ar }) : 'تاريخ غير محدد'}</span>
                                </div>
                                <div className="flex items-center gap-2">
                                    <Clock className="size-4" />
                                    <span>
                                        {even.start_at ? format(new Date(even.start_at), "HH:mm", { locale: ar }) : 'غير محدد'}
                                        {even.end_at ? ` - ${format(new Date(even.end_at), "HH:mm", { locale: ar })}` : ''}
                                    </span>
                                </div>
                                {even.event_type.value === 'physical' ? (
                                    <div className="flex items-center gap-2">
                                        <MapPin className="size-4" />
                                        <span>{even.address ?? 'عنوان غير محدد'}</span>
                                    </div>
                                ) : (
                                    <div className="flex items-center gap-2">
                                        <GlobeIcon className="size-4" />
                                        <span>{even.event_method.label_ar}</span>
                                    </div>
                                )}
                            </div>
                        </div>

                        <hr />

                        {/* الإحصائيات */}
                        <div className="grid grid-cols-2 gap-4 mt-4 md:grid-cols-4">
                            <Card className="p-4 text-center">
                                <CardContent className='flex items-center gap-4'>
                                    <div className="bg-[linear-gradient(135deg,hsl(262,83%,58%),hsl(217,92%,60%))] p-4 rounded-md shadow-md flex items-center justify-center">
                                        <Users className="size-7 text-white" />
                                    </div>
                                    <div className='text-start'>
                                        <p className="text-sm text-muted-foreground font-medium">إجمالي المسجلين</p>
                                        <p className="text-xl font-bold">{even.registrations_count}</p>
                                    </div>
                                </CardContent>
                            </Card>
                            <Card className="p-4 text-center">
                                <CardContent className='flex items-center gap-4'>
                                    <div className="bg-[linear-gradient(135deg,hsl(142,76%,36%),hsl(142,76%,50%))] p-4 rounded-md shadow-md flex items-center justify-center">
                                        <UserCheck2Icon className="size-7 text-white" />
                                    </div>
                                    <div className='text-start'>
                                        <p className="text-sm text-muted-foreground font-medium">الحاضرين</p>
                                        <p className="text-xl font-bold">{even.event_status.value !== 'upcoming' ? event.attended_count : 0}</p>
                                    </div>
                                </CardContent>
                            </Card>
                            <Card className="p-4 text-center">
                                <CardContent className='flex items-center gap-4'>
                                    <div className="badget-70 badget-destructive p-4 rounded-md shadow-md flex items-center justify-center">
                                        <UserX2 className="size-7 text-white" />
                                    </div>
                                    <div className='text-start'>
                                        <p className="text-sm text-muted-foreground font-medium">الغائبين</p>
                                        <p className="text-xl font-bold">{even.event_status.value !== 'upcoming' ? event.not_attended_count : 0}</p>
                                    </div>
                                </CardContent>
                            </Card>
                            <Card className="p-4 text-center">
                                <CardContent className='flex items-center gap-4'>
                                    <div className="badget-70 badget-primary p-4 rounded-md shadow-md flex items-center justify-center">
                                        <UserCheck2Icon className="size-7" />
                                    </div>
                                    <div className='text-start'>
                                        <p className="text-sm text-muted-foreground font-medium">نسبة الحضور</p>
                                        <p className="text-xl font-bold">{even.event_status.value !== 'upcoming' ? event.presentage_attended : 0}%</p>
                                    </div>
                                </CardContent>
                            </Card>
                        </div>
                    </div>

                    {/* قائمة المسجلين */}
                    <div className="mt-6 pb-6">
                        <div className="mb-4">
                            <h2 className="text-lg font-semibold ">المسجلين في الفعالية</h2>
                            <p className='text-muted-foreground'>قائمة بجميع الأعضاء المسجلين وحالة حضورهم</p>
                            <div>
                                <div className="relative max-w-md mt-4">
                                    <Search className="absolute right-3 top-1/2 -translate-y-1/2 h-4 w-4 text-muted-foreground" />
                                    <Input
                                        type="search"
                                        placeholder="البحث عن مسجل (الاسم، البريد، رقم العضوية...)"
                                        onChange={(e) => setSearchTerm(e.target.value)}
                                        onKeyDown={(e) => { if (e.key === 'Enter') fetchRegistrations(even.id, 1); }}
                                        className="pr-10"
                                    />
                                </div>
                            </div>
                        </div>

                        {even.registrations_count === 0 ? (
                            <p className="text-muted-foreground">لا يوجد مسجلين حتى الآن.</p>
                        ) : (
                            <div className="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                                {isLoading ? (
                                    Array.from({ length: Math.min(even.registrations_count, 10) }).map((_, i) => (
                                        <AttendeeCardSkeleton key={i} />
                                    ))
                                ) : registrations.length === 0 ? (
                                    <p className="text-muted-foreground">لا يوجد مسجلين مطابقة لعملية البحث.</p>
                                ) : (
                                    registrations.map((registration) => (
                                        <AttendeeCard
                                            key={registration.id}
                                            registration={registration}
                                            onAttendanceToggle={toggleAttendanceHandler}
                                        />
                                    ))
                                )}
                            </div>
                        )}

                        {/* Pagination */}
                        {pagination.meta?.last_page > 1 && (
                            <div className="flex not-sm:justify-between justify-center mt-6 gap-2 flex-wrap">
                                {/* Previous */}
                                <button
                                    onClick={() => fetchRegistrations(even.id, currentPage - 1)}
                                    disabled={currentPage === 1}
                                    className={`px-3 py-1 rounded border ${currentPage === 1
                                        ? 'opacity-50 cursor-not-allowed'
                                        : 'hover:bg-primary/10 cursor-pointer'
                                        }`}
                                >
                                    السابق
                                </button>

                                {/* Dynamic page buttons */}
                                <div className="flex items-center gap-1 not-sm:hidden">
                                    {Array.from({ length: pagination.meta.last_page }, (_, i) => i + 1)
                                        .filter((page) => {
                                            if (page === 1 || page === pagination.meta.last_page) return true; // always show first and last
                                            if (Math.abs(page - currentPage) <= 2) return true; // show pages around current
                                            return false;
                                        })
                                        .map((page, idx, arr) => {
                                            // add dots if gap
                                            if (idx > 0 && page - arr[idx - 1] > 1) {
                                                return (
                                                    <span key={`dots-${idx}`} className="px-2">…</span>
                                                );
                                            }
                                            return (
                                                <button
                                                    key={page}
                                                    onClick={() => fetchRegistrations(even.id, page)}
                                                    disabled={page === currentPage}
                                                    className={`px-3 py-1 rounded border ${page === currentPage
                                                        ? 'bg-primary/50 cursor-not-allowed'
                                                        : 'hover:bg-primary/10 cursor-pointer'
                                                        }`}
                                                >
                                                    {page}
                                                </button>
                                            );
                                        })}

                                    {/* Next */}
                                </div>
                                <button
                                    onClick={() => fetchRegistrations(even.id, currentPage + 1)}
                                    disabled={currentPage === pagination.meta.last_page}
                                    className={`px-3 py-1 rounded border ${currentPage === pagination.meta.last_page
                                        ? 'opacity-50 cursor-not-allowed'
                                        : 'hover:bg-primary/10 cursor-pointer'
                                        }`}
                                >
                                    التالي
                                </button>
                            </div>
                        )}
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}
