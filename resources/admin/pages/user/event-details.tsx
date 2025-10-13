import { Card, CardContent } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import AppLayout from '@/layouts/app-layout';
import { events } from '@/routes/admin';
import { type BreadcrumbItem } from '@/types';
import { EventModel, EventRegistration, type EventDetails } from '@/types/model/events';
import { Head } from '@inertiajs/react';
import { format } from 'date-fns';
import { ar } from 'date-fns/locale';
import { Calendar, Clock, GlobeIcon, MapPin, Search, UserCheck2Icon, Users, UserX2, Link2 } from 'lucide-react';
import { useEffect, useState } from 'react';
import axios from 'axios';
import  { registrations as register } from '@/routes/admin/event';
import { AttendeeCardSkeleton } from '../_components/events/AttendeeCardSkeleton';
import { AttendeeCard } from '../_components/events/AttendeeCard';
import { toggleAttendance } from '@/routes/admin/event/registrations';
import { toast } from 'sonner';
import { Button } from '@/components/ui/button';
import { confirmAlertDialog } from '@/components/custom/ConfirmDialog';
import { activate, cancel, complete, updateLink } from '@/routes/admin/events';
import { Dialog, DialogContent, DialogHeader, DialogTitle, DialogFooter } from '@/components/ui/dialog';

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'الفعاليات', href: events().url },
];

// --- HeaderEvent Component ---
function HeaderEvent({ eventState, setEventState, completeEventHandler, cancelEventHandler, ongoingEventHandler }: any) {
    const [isDialogOpen, setIsDialogOpen] = useState(false);
    const [link, setLink] = useState(eventState.link || '');
    const [address, setAddress] = useState(eventState.address || '');

    const saveDetails = async () => {
        try {
            const toastId = toast.loading('جاري حفظ التفاصيل...');
            const payload: any = { link };
            if (eventState.event_type.value === 'physical') payload.address = address;
            payload.update_link = true;
            const res = await axios.put(updateLink(eventState.ulid).url, payload); // رابط تحديث مناسب
            setEventState(res.data.event);
            toast.success('تم تحديث التفاصيل بنجاح');
            toast.dismiss(toastId);
            setIsDialogOpen(false);
        } catch (error) {
            console.error(error);
            toast.error('حدث خطأ أثناء تحديث التفاصيل');
        }
    };

    return (
        <div className="flex flex-col gap-2">
            <div className="flex items-center justify-between">
                <h1 className="text-xl font-bold leading-tight tracking-tighter md:text-2xl">
                    {eventState.title}
                </h1>
                <span className={`px-3 py-1 rounded-full text-xs font-medium badget border`}
                    style={{
                        ["--badget-color" as any]: eventState.event_status?.color ?? "#6b7280",
                        borderColor: eventState.event_status?.color ?? "#6b7280",
                    }}
                >
                    <Calendar className="size-3.5 inline-block ml-1" />
                    {eventState.event_status.label_ar}
                </span>
            </div>
            <p className="text-sm text-muted-foreground">{eventState.description}</p>

            <div className='flex justify-between flex-wrap gap-2'>
                <div className="flex items-center text-sm text-muted-foreground flex-wrap gap-3 md:gap-5">
                    <div className="flex items-center gap-2">
                        <Calendar className="size-4" />
                        <span>{eventState.start_at ? format(new Date(eventState.start_at), "d MMMM yyyy", { locale: ar }) : 'تاريخ غير محدد'}</span>
                    </div>
                    <div className="flex items-center gap-2">
                        <Clock className="size-4" />
                        <span>
                            {eventState.start_at ? format(new Date(eventState.start_at), "HH:mm", { locale: ar }) : 'غير محدد'}
                            {eventState.end_at ? ` - ${format(new Date(eventState.end_at), "HH:mm", { locale: ar })}` : ''}
                        </span>
                    </div>
                    {eventState.event_type.value === 'physical' ? (
                        <div className="flex items-center gap-2">
                            <MapPin className="size-4" />
                            <span>{eventState.address ?? 'عنوان غير محدد'}</span>
                        </div>
                    ) : (
                        <div className="flex items-center gap-2">
                            <GlobeIcon className="size-4" />
                            <span>{eventState.event_method.label_ar}</span>
                        </div>
                    )}
                </div>

                {/* أزرار الحالة */}
                <div className="flex items-center gap-2">
                    {eventState.event_status.value === 'ongoing' && (
                        <Button variant="outline" size="sm" onClick={completeEventHandler}>نهاية الفعالية</Button>
                    )}
                    {eventState.event_status.value === 'upcoming' && (
                        <Button variant="outline" size="sm" onClick={cancelEventHandler}>الغاء الفعالية</Button>
                    )}
                    {(eventState.event_status.value === 'cancelled' || eventState.event_status.value === 'completed') && (
                        <Button variant="outline" size="sm" onClick={ongoingEventHandler}>فتح الفعالية</Button>
                    )}
                    {/* زر تعديل التفاصيل */}
                    <Button variant="secondary" size="sm" onClick={() => setIsDialogOpen(true)}>
                        <Link2 className="mr-1" /> تعديل التفاصيل
                    </Button>
                </div>
            </div>

            {/* Dialog تعديل التفاصيل */}
            <Dialog open={isDialogOpen} onOpenChange={setIsDialogOpen}>
                <DialogContent className="sm:max-w-[425px]">
                    <DialogHeader>
                        <DialogTitle>تعديل تفاصيل الفعالية</DialogTitle>
                    </DialogHeader>
                    <div className="grid gap-4 py-4">
                        <Input
                            placeholder="رابط الفعالية"
                            value={link}
                            defaultValue={eventState.link || ''}
                            onChange={(e) => setLink(e.target.value)}
                        />
                        {eventState.event_type.value === 'physical' && (
                            <Input
                                placeholder="العنوان"
                                value={address}
                                defaultValue={eventState.address || ''}
                                onChange={(e) => setAddress(e.target.value)}
                            />
                        )}
                    </div>
                    <DialogFooter className="flex justify-end gap-2">
                        <Button variant="outline" onClick={() => setIsDialogOpen(false)}>إلغاء</Button>
                        <Button onClick={saveDetails}>حفظ</Button>
                    </DialogFooter>
                </DialogContent>
            </Dialog>
        </div>
    );
}

// --- EventStats Component ---
function EventStats({ eventState, event }: any) {
    return (
        <div className="grid grid-cols-2 gap-4 mt-4 md:grid-cols-4">
            <Card className="p-4 text-center">
                <CardContent className='flex items-center gap-4'>
                    <div className="bg-[linear-gradient(135deg,hsl(262,83%,58%),hsl(217,92%,60%))] p-4 rounded-md shadow-md flex items-center justify-center">
                        <Users className="size-7 text-white" />
                    </div>
                    <div className='text-start'>
                        <p className="text-sm text-muted-foreground font-medium">إجمالي المسجلين</p>
                        <p className="text-xl font-bold">{eventState.registrations_count}</p>
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
                        <p className="text-xl font-bold">{eventState.event_status.value !== 'upcoming' ? event.attended_count : 0}</p>
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
                        <p className="text-xl font-bold">{eventState.event_status.value !== 'upcoming' ? event.not_attended_count : 0}</p>
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
                        <p className="text-xl font-bold">{eventState.event_status.value !== 'upcoming' ? event.presentage_attended : 0}%</p>
                    </div>
                </CardContent>
            </Card>
        </div>
    );
}

// --- AttendeesList Component ---
function AttendeesList({ eventState, registrations, isLoading, searchTerm, setSearchTerm, fetchRegistrations, toggleAttendanceHandler, currentPage, pagination }: any) {
    return (
        <div className="mt-6 pb-6">
            <div className="mb-4">
                <h2 className="text-lg font-semibold ">المسجلين في الفعالية</h2>
                <p className='text-muted-foreground'>قائمة بجميع الأعضاء المسجلين وحالة حضورهم</p>
                <div className="relative max-w-md mt-4">
                    <Search className="absolute right-3 top-1/2 -translate-y-1/2 h-4 w-4 text-muted-foreground" />
                    <Input
                        type="search"
                        placeholder="البحث عن مسجل (الاسم، البريد، رقم العضوية...)"
                        onChange={(e) => setSearchTerm(e.target.value)}
                        onKeyDown={(e) => { if (e.key === 'Enter') fetchRegistrations(eventState.id, 1); }}
                        className="pr-10"
                    />
                </div>
            </div>

            {eventState.registrations_count === 0 ? (
                <p className="text-muted-foreground">لا يوجد مسجلين حتى الآن.</p>
            ) : (
                <div className="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                    {isLoading ? (
                        Array.from({ length: Math.min(eventState.registrations_count, 10) }).map((_, i) => (
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
                    <button
                        onClick={() => fetchRegistrations(eventState.id, currentPage - 1)}
                        disabled={currentPage === 1}
                        className={`px-3 py-1 rounded border ${currentPage === 1 ? 'opacity-50 cursor-not-allowed' : 'hover:bg-primary/10 cursor-pointer'}`}
                    >السابق</button>
                    <div className="flex items-center gap-1 not-sm:hidden">
                        {Array.from({ length: pagination.meta.last_page }, (_, i) => i + 1)
                            .filter((page) => {
                                if (page === 1 || page === pagination.meta.last_page) return true;
                                if (Math.abs(page - currentPage) <= 2) return true;
                                return false;
                            })
                            .map((page, idx, arr) => {
                                if (idx > 0 && page - arr[idx - 1] > 1) return <span key={`dots-${idx}`} className="px-2">…</span>;
                                return (
                                    <button
                                        key={page}
                                        onClick={() => fetchRegistrations(eventState.id, page)}
                                        disabled={page === currentPage}
                                        className={`px-3 py-1 rounded border ${page === currentPage ? 'bg-primary/50 cursor-not-allowed' : 'hover:bg-primary/10 cursor-pointer'}`}
                                    >{page}</button>
                                );
                            })}
                    </div>
                    <button
                        onClick={() => fetchRegistrations(eventState.id, currentPage + 1)}
                        disabled={currentPage === pagination.meta.last_page}
                        className={`px-3 py-1 rounded border ${currentPage === pagination.meta.last_page ? 'opacity-50 cursor-not-allowed' : 'hover:bg-primary/10 cursor-pointer'}`}
                    >التالي</button>
                </div>
            )}
        </div>
    );
}

// --- Main Page ---
export default function PageEventDetails({ event }: { event: EventDetails }) {
    const { event: even } = event as { event: EventModel };
    const [eventState, setEventState] = useState<EventModel>(even);
    const [registrations, setRegistrations] = useState<EventRegistration[]>([]);
    const [pagination, setPagination] = useState<{ links: any, meta: any }>({ links: {}, meta: {} });
    const [searchTerm, setSearchTerm] = useState<string>('');
    const [isLoading, setIsLoading] = useState<boolean>(false);
    const [currentPage, setCurrentPage] = useState<number>(1);

    useEffect(() => { fetchRegistrations(eventState.id); }, []);

    async function fetchRegistrations(eventId: number, page: number = 1) {
        setIsLoading(true);
        try {
            const response = await axios.get(register(eventId).url, { params: { search: searchTerm, page } });
            setRegistrations(response.data.registrations);
            setPagination(response.data);
            setCurrentPage(page);
        } catch (error) { console.error('Error fetching registrations:', error); }
        finally { setIsLoading(false); }
    }

    const toggleAttendanceHandler = async (registrationId: number) => {
        const toastId = toast.loading('جاري تحديث حالة الحضور...');
        try {
            const res = await axios.put(toggleAttendance(registrationId).url);
            setRegistrations((prev) => prev.map((reg) => reg.id === registrationId ? res.data.registration : reg));
        } catch (error) {
            console.error(error);
            toast.error('حدث خطأ أثناء تحديث حالة الحضور. حاول مرة أخرى.');
        }
        toast.dismiss(toastId);
    };

    const cancelEventHandler = async () => {
        try {
            const ok = await confirmAlertDialog({ title: 'هل أنت متأكد من إلغاء الفعالية؟', description: 'لن يتمكن المسجلين من حضور الفعالية بعد الآن.' });
            if (!ok) return;
            const toastId = toast.loading('جاري إلغاء الفعالية...');
            const res = await axios.put(cancel(eventState.ulid).url);
            setEventState(res.data?.event);
            toast.success('تم إلغاء الفعالية بنجاح.');
            toast.dismiss(toastId);
        } catch (error) { toast.error('حدث خطأ أثناء إلغاء الفعالية. حاول مرة أخرى.'); }
    };

    const completeEventHandler = async () => {
        try {
            const ok = await confirmAlertDialog({ title: 'هل أنت متأكد من إنهاء الفعالية؟', description: 'لن يتمكن المسجلين من حضور الفعالية بعد الآن.' });
            if (!ok) return;
            const toastId = toast.loading('جاري إنهاء الفعالية...');
            const res = await axios.put(complete(eventState.ulid).url);
            setEventState(res.data?.event);
            toast.success('تم إنهاء الفعالية بنجاح.');
            toast.dismiss(toastId);
        } catch (error) { toast.error('حدث خطأ أثناء إنهاء الفعالية. حاول مرة أخرى.'); }
    };

    const ongoingEventHandler = async () => {
        try {
            const ok = await confirmAlertDialog({ title: 'هل أنت متأكد من فتح الفعالية؟', description: 'سيتمكن المسجلين من حضور الفعالية مرة أخرى.' });
            if (!ok) return;
            const toastId = toast.loading('جاري فتح الفعالية...');
            const res = await axios.put(activate(eventState.ulid).url);
            setEventState(res.data?.event);
            toast.success('تم فتح الفعالية بنجاح.');
            toast.dismiss(toastId);
        } catch (error) { toast.error('حدث خطأ أثناء فتح الفعالية. حاول مرة أخرى.'); }
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title={eventState.title} />
            <div className="flex flex-1 flex-col px-4 md:px-4 lg:px-6">
                <div className="@container/main flex flex-1 flex-col gap-2">
                    <HeaderEvent
                        eventState={eventState}
                        
                        setEventState={setEventState}
                        completeEventHandler={completeEventHandler}
                        cancelEventHandler={cancelEventHandler}
                        ongoingEventHandler={ongoingEventHandler}
                    />
                    <hr />
                    <EventStats eventState={eventState} event={event} />
                    <AttendeesList
                        eventState={eventState}
                        registrations={registrations}
                        isLoading={isLoading}
                        searchTerm={searchTerm}
                        setSearchTerm={setSearchTerm}
                        fetchRegistrations={fetchRegistrations}
                        toggleAttendanceHandler={toggleAttendanceHandler}
                        currentPage={currentPage}
                        pagination={pagination}
                    />
                </div>
            </div>
        </AppLayout>
    );
}
