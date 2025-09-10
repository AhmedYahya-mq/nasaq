import { ComboboxItem } from "@/types";

// خيارات حالة الدفع
export const paymentStatusOptions: ComboboxItem[] = [
    { value: "Pending", label: "قيد الانتظار" },
    { value: "Paid", label: "مدفوع" },
    { value: "Failed", label: "فشل" },
];

// خيارات حالة الطلب
export const applicationStatusOptions: ComboboxItem[] = [
    { value: "Pending", label: "قيد المراجعة" },
    { value: "Approved", label: "مقبول" },
    { value: "Rejected", label: "مرفوض" },
];

// خيار هل يمكن إعادة التقديم
export const canResubmitOptions: ComboboxItem[] = [
    { value: "true", label: "نعم" },
    { value: "false", label: "لا" },
];

// خيارات عدد الصفوف
export const rowsOptions: ComboboxItem[] = [
    { value: "5", label: "5 صفوف" },
    { value: "10", label: "10 صفوف" },
    { value: "20", label: "20 صفوف" },
    { value: "50", label: "50 صف" },
];
