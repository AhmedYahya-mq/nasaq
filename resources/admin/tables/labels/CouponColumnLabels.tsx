import { discountCell } from "@/components/table/cells/discountCell";
import { statusCell } from "@/components/table/cells/statusCell";
import { ColumnLabels } from "@/types";
import { log } from "console";
export const CouponColumnLabels: Record<string, ColumnLabels> = {
    id: { label: 'ID' },
    code: { label: 'الكود' },
    discount_type: { label: 'نوع الخصم' },
    value: {
        label: 'قيمة الخصم'
    },
    applies_to_label: { label: 'يطبق على' },
    max_uses: { label: 'الحد الأقصى' },
    used_count: { label: 'عدد الاستخدام' },
    remaining_uses: { label: 'المتبقي' },
    starts_at: { label: 'يبدأ في' },
    expires_at: { label: 'ينتهي في' },
    status: {
        label: 'الحالة', render(value) {
            return value ? <span className="inline-flex items-center justify-center gap-1 rounded-full px-2 py-1 text-xs" style={{ backgroundColor: value.color, color: "#fff" }}>{value.label_ar}</span> : '-';
        },
    },
    discount_display: { label: 'عرض الخصم', hidden: true },
    applies_to: { label: 'applies_to', hidden: true },
    is_active: { label: 'is_active', hidden: true },
    created_at: { label: 'تاريخ الإنشاء', hidden: true },
    updated_at: { label: 'تاريخ التحديث', hidden: true },
};
