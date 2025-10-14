import { Search, Clock, Mail, ArrowLeftIcon, ArrowRightIcon } from "lucide-react";
import { Input } from "@/components/ui/input";
import { Card } from "@/components/ui/card";
import { Badge } from "@/components/ui/badge";
import { cn } from "@/lib/utils";
import { MembershipApplication } from "@/types/model/membershipApplication";

import { Button } from "@/components/ui/button";
import { Skeleton } from "@/components/ui/skeleton";
import { useState } from "react";

interface EmailListProps {
    pagination: PaginatedData<MembershipApplication>;
    selectedApplication: MembershipApplication | null;
    onApplicationSelect: (application: MembershipApplication) => void;
    searchQuery: string;
    onSearchChange: (query: string) => void;
    onPageChange: (page: number) => void;
    selectedFolder: string;
    onFolderChange: (folder: string) => void;
    className?: string;
    loading?: boolean; // أضف هذا البروب
}

// الحالات المتاحة للفلترة
const statusOptions = [
    { value: "", label: "الكل" },
    { value: "pending", label: "قيد الانتظار" },
    { value: "approved", label: "مقبول" },
    { value: "rejected", label: "مرفوض" },
    { value: "cancelled", label: "ملغاة" },
];

export function EmailList({
    pagination,
    selectedApplication,
    onApplicationSelect,
    searchQuery,
    onSearchChange,
    onPageChange,
    selectedFolder,
    onFolderChange,
    className,
    loading // أضف هذا البروب
}: EmailListProps & { loading?: boolean }) {
    pagination = pagination || { data: [], meta: { current_page: 1, last_page: 1, per_page: 10, total: 0 }, links: { next: null, prev: null } };
    const applications = pagination.data;

    const [searchTerm, setSearchTerm] = useState(searchQuery);

    const onClickSearch = () => {
        onSearchChange(searchTerm);
    }


    // بطاقات Skeleton الوهمية
    const skeletonCards = Array.from({ length: 10 }).map((_, idx) => (
        <Card key={idx} className="p-4">
            <div className="flex items-start justify-between mb-2">
                <div className="flex items-center gap-2 min-w-0 flex-1">
                    <Skeleton className="h-6 w-6 rounded-full" />
                    <Skeleton className="h-4 w-32" />
                </div>
                <Skeleton className="h-3 w-14" />
            </div>
            <Skeleton className="h-4 w-40 mb-2" />
            <Skeleton className="h-3 w-full mb-1" />
            <Skeleton className="h-3 w-3/4 mb-1" />
            <Skeleton className="h-3 w-2/3 mb-2" />
            <Skeleton className="h-5 w-20" />
        </Card>
    ));

    return (
        <div className={cn([className, "border-r w-full border-border bg-background flex flex-col"])} >
            {/* Search */}
            <div className="p-4 border-b border-border">
                <div className="relative mb-2">
                    <Button variant="ghost" size="icon" onClick={() => onClickSearch()} className="absolute left-3 top-1/2 cursor-pointer transform -translate-y-1/2 h-8 w-8 text-muted-foreground">
                        <Search className="h-4 w-4" />
                    </Button>
                    <Input
                        placeholder="بحث عن الطلبات..."
                        value={searchTerm}
                        onChange={(e) => {
                            setSearchTerm(e.target.value);
                            // اذا تفرغ يروح يعمل بحث فاضي
                            if (e.target.value === '') {
                                onSearchChange('');
                            }
                        }}

                        onKeyDown={(e) => { if (e.key === 'Enter') { onClickSearch(); } }}
                        className="pl-10 bg-muted/50 border-muted"
                    />
                </div>
                {/* فلترة الحالات */}
                <div className="flex gap-2 mt-2 not-sm:flex-wrap">
                    {statusOptions.map((opt) => (
                        <Button
                            key={opt.value}
                            variant={selectedFolder === opt.value ? "default" : "outline"}
                            size="sm"
                            onClick={() => onFolderChange(opt.value)}
                        >
                            {opt.label}
                        </Button>
                    ))}
                </div>
            </div>

            {/* Email List */}
            <div className="flex-1 min-[1115px]:max-h-screen scrollbar">
                <div className="p-2">
                    {loading ? (
                        <div className="space-y-1">{skeletonCards}</div>
                    ) : applications?.length === 0 ? (
                        <div className="text-center py-8 text-muted-foreground">
                            <Mail className="h-8 w-8 mx-auto mb-2 opacity-50" />
                            <p>لا يوجد اي طلبات</p>
                        </div>
                    ) : (
                        <div className="space-y-1">
                            {applications?.map((application) => (
                                <Card
                                    key={application.id}
                                    className={cn(
                                        "p-4 cursor-pointer border transition-all duration-200 hover:shadow-application",
                                        selectedApplication?.id === application.id
                                            ? "bg-card/45 border-1 border-primary shadow"
                                            : "hover:bg-muted/50 border-transparent",
                                        application.status.value === "pending" && "border-l-4 border-l-primary"
                                    )}
                                    onClick={() => onApplicationSelect(application)}
                                >
                                    <div className="flex items-start justify-between mb-2">
                                        <div className="flex items-center gap-2 min-w-0 flex-1">
                                            <span className={cn(
                                                "font-medium truncate text-muted-foreground",
                                                application.status.value === "pending" ? "text-foreground" : "text-muted-foreground"
                                            )}>
                                                {application.user?.name}
                                            </span>
                                            {application.status.value === "pending" && (
                                                <div className="w-2 h-2 bg-primary rounded-full flex-shrink-0 animate-pulse" />
                                            )}
                                        </div>
                                        <div className="flex items-center gap-1 text-xs text-muted-foreground flex-shrink-0">
                                            <Clock className="h-3 w-3" />
                                            {application.created_at_human}
                                        </div>
                                    </div>

                                    <h3 className={cn(
                                        "text-sm mb-1 truncate",
                                        application.status.value === "pending" ? "font-semibold text-foreground" : "font-medium text-muted-foreground"
                                    )}>
                                        {application.membership_type}
                                    </h3>

                                    <p className="text-xs text-muted-foreground line-clamp-3">
                                        {application.user?.name} قدم طلب عضوية من نوع <strong>{application.membership_type}</strong>.
                                        يشمل الطلب البيانات الشخصية الأساسية مثل الهوية الوطنية، المسمى الوظيفي، جهة العمل، ورقم الهيئة (إذا وجد)، بالإضافة إلى الملفات المرفوعة لدعم الطلب.
                                        راجع تفاصيل الطلب بالكامل لتقييمه والموافقة أو الرفض.
                                    </p>

                                    {application.files && application.files.length > 0 && (
                                        <div className="mt-2">
                                            <Badge variant="outline" className="text-xs">
                                                📎 {application.files.length} attachment{application.files.length > 1 ? 's' : ''}
                                            </Badge>
                                        </div>
                                    )}
                                </Card>
                            ))}
                        </div>
                    )}
                </div>
            </div>

            {/* pagination next and prev */}
            <div>
                <div className="p-4 border-t border-border bg-card flex items-center justify-between">
                    <span className="text-sm text-muted-foreground">
                        صفحة {pagination.meta.current_page} من {pagination.meta.last_page}
                    </span>
                    <div className="space-x-2">
                        <Button
                            variant="outline"
                            size="sm"
                            disabled={!pagination.links.prev}
                            onClick={() => pagination.meta.current_page > 1 && onPageChange(pagination.meta.current_page - 1)}
                        >
                            <ArrowLeftIcon className="h-4 w-4" />
                        </Button>
                        <Button
                            variant="outline"
                            size="sm"
                            disabled={!pagination.links.next}
                            onClick={() => pagination.meta.current_page < pagination.meta.last_page && onPageChange(pagination.meta.current_page + 1)}
                        >
                            <ArrowRightIcon className="h-4 w-4" />
                        </Button>
                    </div>
                </div>
            </div>
        </div>
    );
}
