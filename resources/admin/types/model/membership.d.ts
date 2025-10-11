import { ColumnDef } from "@tanstack/react-table";
import { ColumnLabels } from "..";

export interface Membership {
    id: number;
    name: string;
    name_en: string;
    description?: string;
    description_en?: string;
    price: number | string;
    is_active: boolean;
    discounted_price?: number | string | null;
    percent_discount?: number | string | null;
    duration_days?: number | null;
    requirements?: string[];
    requirements_en?: string[];
    features?: string[];
    level: number;
    features_en?: string[];
    sort_order?: number | null;
    created_at?: string | null;
    updated_at?: string | null;
}


export interface UseTableMembershipsProps {
    memberships: Membership[];
    columns: ColumnDef<Membership>[];
}
