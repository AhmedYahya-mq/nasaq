import { ColumnDef } from "@tanstack/react-table";
import { ColumnLabels } from "..";
import IconRial from "@/components/icon-rial";
import { formatTimeUnit } from "@/lib/utils";

export interface Membership {
    id: number;
    name: string;
    name_en: string;
    description?: string;
    description_en?: string;
    price: number | string; // changed to accept API decimal strings
    is_active: boolean;
    discounted_price?: number | string | null;
    duration_days?: number | null;
    requirements?: string[];
    requirements_en?: string[];
    features?: string[];
    features_en?: string[];
    sort_order?: number | null;
    created_at?: string | null;
    updated_at?: string | null;
}


export interface UseTableMembershipsProps {
    memberships: Membership[];
    columns: ColumnDef<Membership>[];
}

// مفتاح الحقل → اسم العمود المعروض
export const membershipColumnLabels: Record<keyof Membership, ColumnLabels> = {
    id: { label: 'ID' },
    name: { label: 'الاسم' },
    name_en: { label: 'Name (EN)' },
    description: { label: 'الوصف' },
    description_en: { label: 'Description (EN)' },
    price: { label: 'السعر', suffix: <IconRial className="size-3.5 *:fill-primary" /> },
    is_active: { label: 'حالة العضوية', render: (value: any) => value ? 'نشط' : 'غير نشط' },
    discounted_price: { label: 'السعر بعد الخصم', suffix: <IconRial className="size-3.5 *:fill-primary" />  },
    duration_days: { label: 'مدة الاشتراك (أيام)', render: (value: any) => value ? formatTimeUnit(value, 'day') : '-' },
    requirements: { label: 'المتطلبات' },
    requirements_en: { label: 'Requirements (EN)' },
    features: { label: 'المميزات' },
    features_en: { label: 'Features (EN)' },
    sort_order: { label: 'ترتيب العرض' },
    created_at: { label: 'تاريخ الإنشاء' },
    updated_at: { label: 'تاريخ التحديث' },
};
