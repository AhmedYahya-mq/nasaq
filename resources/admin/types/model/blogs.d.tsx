import { ColumnDef } from "@tanstack/react-table";
import { ColumnLabels } from "..";


export interface Blog {
    id: number;
    title: string;
    title_en: string;
    content?: string;
    content_en?: string;
    excerpt?: string;
    excerpt_en?: string;
    slug?: string;
    author?: string;
    image: string;
    views: number;
    created_at?: string | null;
    updated_at?: string | null;
}

export interface UseTableBlogsProps {
    blogs: Blog[];
    columns: ColumnDef<Blog>[];
}

// مفتاح الحقل → اسم العمود المعروض
export const blogColumnLabels: Record<keyof Blog, ColumnLabels> = {
    id:{ label: 'ID' },
    title: { label: 'العنوان' },
    title_en: { label: 'Title (EN)' },
    content: { label: 'المحتوى' },
    content_en: { label: 'Content (EN)' },
    excerpt: { label: 'المقتطف' },
    excerpt_en: { label: 'Excerpt (EN)' },
    slug: { label: 'الرابط المختصر' },
    author: { label: 'المؤلف' },
    image: { label: 'الصورة', render: (value: any) => value ? <img src={value} alt="Blog Image" className="size-10 object-cover rounded" /> : 'لا توجد صورة' },
    views: { label: 'عدد المشاهدات' },
    created_at: { label: 'تاريخ الإنشاء' },
    updated_at: { label: 'تاريخ التحديث' },
};
