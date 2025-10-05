import { ColumnLabels } from "@/types";
import { Blog } from "@/types/model/blogs";
import { ImageItem } from "@/types/model/photo";

// مفتاح الحقل → اسم العمود المعروض
export const blogColumnLabels: Record<keyof Blog, ColumnLabels> = {
    id: { label: 'ID' },
    title: { label: 'العنوان' },
    title_en: { label: 'Title (EN)' },
    content: {
        label: 'المحتوى',
        render: (content: any) => <div
            style={{
                display: "-webkit-box",
                WebkitLineClamp: 3,
                WebkitBoxOrient: "vertical",
                overflow: "hidden",
            }}
            dangerouslySetInnerHTML={{ __html: content }} ></div>
    },
    content_en: {
        label: 'Content (EN)',
        render: (content: any) => <div
            style={{
                display: "-webkit-box",
                WebkitLineClamp: 3,   // عدد الأسطر
                WebkitBoxOrient: "vertical",
                overflow: "hidden",
            }}
            dangerouslySetInnerHTML={{ __html: content }} ></div>
    },
    excerpt: { label: 'المقتطف' },
    excerpt_en: { label: 'Excerpt (EN)' },
    slug: { label: 'الرابط المختصر' },
    author: {
        label: 'النأشر',
        render: (user: any) => <span className="text-md font-semibold">{user}</span>
    },
    image: {
        label: 'الصورة',
        render: (image: ImageItem) =>
            image && typeof image.url === "string"
                ? <img src={image.url} alt={image.name} className="size-10 object-cover rounded" />
                : 'لا توجد صورة'
    },
    views: { label: 'عدد المشاهدات' },
    created_at: { label: 'تاريخ الإنشاء' },
    updated_at: { label: 'تاريخ التحديث' },
};
