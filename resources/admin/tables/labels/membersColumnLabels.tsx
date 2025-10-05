import { formatDate, formatFullDate } from "@/lib/utils";
import { ColumnLabels } from "@/types";
import { MembershipAppStatues } from "@/types/enums/membership_app";
import { Members } from "@/types/model/members.d";
import { Badge } from "@/components/ui/badge";
import { ArrowUpLeftFromSquareIcon } from "lucide-react";

export const membersColumnLabels: Record<keyof Members, ColumnLabels> = {
    id: { label: 'ID' },
    name: { label: 'الاسم' },
    email: { label: 'البريد الإلكتروني' },
    profile_photo_url: {
        label: 'الصورة',
        render: (path: any) => path ?
            <a
                href={path}
                target="_blank"
                rel="noopener noreferrer"
                className="relative group size-10 rounded-md overflow-hidden cursor-pointer"
                title="فتح الصورة في نافذة جديدة"
            >
                <img
                    src={path}
                    alt="Profile"
                    className="size-10 rounded-md object-cover cursor-pointer"
                />
                <div className="absolute size-10 top-0 rounded-md cursor-pointer bg-black/20 flex items-center justify-center transition-opacity duration-200 opacity-0 group-hover:opacity-100">
                    <ArrowUpLeftFromSquareIcon className="w-4 h-4 stroke-primary" />
                </div>
            </a>
            : 'لا توجد صورة',
    },
    phone: { label: 'رقم الجوال' },
    birthday: { label: 'تاريخ الميلاد', render: (value: any) => value ? formatFullDate(value, false) : '-' },
    address: { label: 'العنوان' },
    job_title: { label: 'المسمى الوظيفي' },
    bio: { label: 'نبذة عن العضو' },
    is_active: { label: 'الحالة', render: (value: any) => value ? 'مفعل' : 'محظور' },
    email_verified_at: { label: 'تاريخ التحقق من البريد الإلكتروني', render: (value: any) => value ? formatDate(value) : 'غير محقق' },
    two_factor_enabled: { label: 'المصادقة الثنائية', render: (value: any) => value ? 'مفعلة' : 'غير مفعلة' },
    membership_name: { label: 'نوع العضوية' },
    membership_status: {
        label: 'حالة العضوية', render: (status: MembershipAppStatues) => <Badge
            style={{
                backgroundColor: status.color,
                color: "white",
            }}
        >
            {status.label_ar}
        </Badge>
    },
    membership_expires_at: { label: 'تاريخ انتهاء العضوية', render: (value: any) => value ? formatFullDate(value, false) : '-' },
    membership_active: { label: 'العضوية مفعلة', render: (value: any) => value ? 'نعم' : 'لا' },
    employment_status: {
        label: 'الحالة الوظيفية',
        render: (value: any) => <Badge
            style={{
                backgroundColor: value.color,
                color: "white",
            }}
        >
            {value.label_ar}
        </Badge>
    },
    membership: { label: 'العضوية' },
    membership_Applications: { label: 'طلبات العضوية' },
    membership_Applications_count: { label: 'عدد طلبات العضوية' },
    created_at: { label: 'تاريخ الإنشاء', render: (value: any) => value ? formatDate(value) : '-' },
    updated_at: { label: 'تاريخ التحديث', render: (value: any) => value ? formatDate(value) : '-' },
}
