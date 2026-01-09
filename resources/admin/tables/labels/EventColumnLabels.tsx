import IconRial from "@/components/icons/icon-rial";
import { Badge } from "@/components/ui/badge";
import { arabicPluralize, formatFullDate } from "@/lib/utils";
import { ColumnLabels } from "@/types";
import { EventModel } from "@/types/model/events";

export const EventColumnLabels: Record<keyof EventModel, ColumnLabels> = {
    id: { label: 'ID' },
    ulid: { label: 'ULID' },
    title: { label: 'العنوان' },
    title_en: { label: 'Title (EN)', render: (value: any) => value ?? '-' },
    description: { label: 'الوصف' },
    description_en: { label: 'Description (EN)', render: (value: any) => value ?? '-' },
    event_type: {
        label: 'نوع الحدث',
        render: (value: any) => value ? (
            <Badge style={{
                backgroundColor: value.color,
                color: "white",
            }}>
                {value.label_ar}
            </Badge>
        ) : '-'
    },

    event_status: {
        label: 'حالة الحدث',
        render: (value: any) => value ? (
            <Badge style={{
                backgroundColor: value.color,
                color: "white",
            }}>
                {value.label_ar}
            </Badge>
        ) : '-'
    },
    event_category: {
        label: 'فئة الحدث',
        render: (value: any) => value ? (
            <Badge style={{
                backgroundColor: value.color,
                color: "white",
            }}>
                {value.label_ar}
            </Badge>
        ) : '-'
    },
    event_method: {
        label: 'سيقام من خلال',
        render: (value: any) => value ? (
            <Badge style={{
                backgroundColor: value.color,
                color: "white",
            }}>
                {value.label_ar}
            </Badge>
        ) : '-'
    },
    address: { label: 'العنوان', render: (value: any) => value ?? '-' },
    address_en: { label: 'Address (EN)', render: (value: any) => value ?? '-' },
    capacity: {
        label: 'السعة', render: (value: any) => arabicPluralize(value, {
            singular: 'مشارك',
            dual: 'مشاركان',
            plural: 'مشاركين'
        })
    },
    start_at: { label: 'تاريخ البداية', render: (value: any) => value ? formatFullDate(value, false) : '-' },
    end_at: { label: 'تاريخ النهاية', render: (value: any) => value ? formatFullDate(value, false) : '-' },
    link: { label: 'الرابط', render: (value: string | null) => value ? <a href={value} target="_blank" rel="noopener noreferrer" className="text-blue-600 underline">رابط الحدث</a> : '-' },
    membership_names: {
        label: 'من يستطيع التسجيل', render: (names: string[] | null) => <div className="flex flex-wrap gap-1">
            {names && names.length > 0 ? (
                names.map((name, index) => (
                    <span
                        key={index}
                        className="badget badget-primary rounded-2xl px-2"
                    >
                        {name}
                    </span>
                ))
            ) : (
                <span className="badget badget-primary rounded-2xl px-2">الكل</span>
            )}
        </div>
    },
    price: {
        label: 'السعر', render: (value: any) => value !== null && value !== undefined && value > 0 ?
            <span className="flex items-center gap-1">
                {value} <IconRial className="size-3.5 *:fill-primary" />
            </span> : <span>مجاني</span>
    },
    discount: { label: 'الخصم', render: (value: any) => value && value > 0 ? `${value}%` : 'لا يوجد' },
    final_price: {
        label: 'السعر بعد الخصم', render: (value: any) => value !== null && value !== undefined && value > 0 ?
            <span className="flex items-center gap-1">
                {value} <IconRial className="size-3.5 *:fill-primary" />
            </span> : <span>مجاني</span>
    },
    registrations_count: {
        label: 'عدد المسجلين', render: (value: any) => arabicPluralize(value, {
            singular: 'مسجل',
            dual: 'مسجلان',
            plural: 'مسجلين'
        })
    },
    is_featured: { label: 'مميز', render: (value: any) => value ? 'نعم' : 'لا' },
    is_full: { label: 'مكتمل', hidden: true },
    created_at: { label: 'تاريخ الإنشاء', hidden: true },
    updated_at: { label: 'تاريخ التحديث', hidden: true },
    membership_ids: { label: 'Membership IDs', hidden: true },
    is_started: { label: 'is_started', hidden: true },
    is_ended: { label: 'is_ended', hidden: true }
};
