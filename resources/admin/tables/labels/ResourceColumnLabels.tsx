import { ColumnLabels } from "@/types";
import { Resource } from "@/types/model/resources";


export  const resourceColumnLabels: Record<keyof Resource, ColumnLabels> = {
    id: { label: 'ID' },
    ulid: { label: 'ULID' },
    title: { label: 'العنوان' },
    title_en: { label: 'Title (EN)' },
    description: { label: 'الوصف' },
    description_en: { label: 'Description (EN)' },
    author: { label: 'المؤلف' },
    author_en: { label: 'Author (EN)' },
    path: { label: 'الرابط' },
    type: { label: 'النوع', render: (type: any) => type?.label || 'غير محدد' },
    status: { label: 'الحالة', render: (status: any) => status?.label || 'غير محدد' },
    price: { label: 'السعر' },
    discount: { label: 'الخصم' },
    created_at: { label: 'تاريخ الإنشاء' },
    updated_at: { label: 'تاريخ التحديث' },
}