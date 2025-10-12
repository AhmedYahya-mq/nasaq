import { ResourcesEnum } from "@/types/enums/resources";
import { ImageItem } from "./photo";
interface Resource {
    id: number;
    ulid: string;
    title: string;
    title_en: string;
    description: string;
    description_en: string;
    author: string;
    author_en: string;
    user_count: number;
    year_published: number;
    published_at: string;
    path: string;
    poster: ImageItem;
    type: ResourcesEnum;
    status: ResourcesEnum;
    price: number;
    discount: number;
    created_at: string;
    updated_at: string;
}