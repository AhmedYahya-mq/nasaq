interface CouponModel {
    id: number;
    code: string;
    discount_type: 'percent' | 'fixed';
    value: number;
    applies_to: 'event' | 'membership' | 'library' | 'all';
    applies_to_label: string;
    max_uses: number | null;
    used_count: number;
    remaining_uses: number | null;
    starts_at: string | null;
    expires_at: string | null;
    status: {
        value: 'active' | 'expired' | 'scheduled';
        label_ar: string;
        color: string;
    };
    is_active: boolean;
    discount_display: string | number;
    created_at: string;
    updated_at: string;
}
