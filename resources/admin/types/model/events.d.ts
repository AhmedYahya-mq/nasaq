import { EventEnum } from "@/enums/EventEnum";
interface EventModel {
    id: number;
    ulid: string;
    title: string;
    title_en: string;
    description: string | null;
    description_en: string | null;
    address: string | null;
    address_en: string | null;
    event_type: EventEnum;
    event_status: EventEnum;
    event_category: EventEnum;
    event_method: EventEnum;
    capacity: number | null;
    start_at: string;
    end_at: string;
    link: string | null;
    membership_names: string[] | null;
    membership_ids: string[] | null;
    price: number | null;
    discount: number | null;
    final_price: number | null;
    registrations_count: number;
    is_featured: boolean;
    is_full: boolean;
    created_at: string;
    updated_at: string;
}

interface EventRegistration {
    id: number;
    user:{
        id: number;
        member_id?: string | null;
        name: string;
        email: string;
        phone: string;
        profile_photo_url?: string;
        profile_link: string | null;
        membership_status: string | null;
        membership?: string | null;
    }
    joined_at?: string;
    join_ip?: string | null;
    join_link?: string | null;
    created_at: string;
}

type EventDetails = {
    event: EventModel;
    registrations: EventRegistration[];
    attended_count: number;
    not_attended_count: number;
    presentage_attended: string;
};