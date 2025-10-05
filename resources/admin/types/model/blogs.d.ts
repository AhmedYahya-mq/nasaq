import { ColumnDef } from "@tanstack/react-table";
import { ColumnLabels } from "..";
import { ImageItem } from "./photo";
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
    image: ImageItem | null;
    views: number;
    created_at?: string | null;
    updated_at?: string | null;
}

export interface UseTableBlogsProps {
    blogs: Blog[];
    columns: ColumnDef<Blog>[];
}
