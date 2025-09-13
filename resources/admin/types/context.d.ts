/**
 * واجهة سياق تأكيد التنبيه (Alert/Confirm)
 */
export interface AlertConfirmContextType {
    /** هل نافذة التأكيد مفتوحة */
    isOpen: boolean;
    /** العنصر المستهدف للحذف أو التأكيد */
    item: any | null;
    /** تعيين العنصر المستهدف */
    setItem: React.Dispatch<React.SetStateAction<any>>;
    /** تعيين حالة الفتح/الإغلاق للنافذة */
    setIsOpen: React.Dispatch<React.SetStateAction<boolean>>;
    /** دالة فتح نافذة التأكيد مع تعيين دالة الحذف والعنصر */
    handleDelete?: (fn: () => Promise<boolean>, targetItem: any) => void
    /** دالة التأكيد (تنفيذ الحذف) */
    onConfirm: () => void;
}


/**
 * واجهة سياق إدارة النماذج (فتح/تعديل/ترجمة العضوية)
 */
interface OpenFormContextType {
    /** تعيين حالة فتح النموذج */
    setOpen?: (value: boolean) => void;
    /** هل النموذج مفتوح */
    isOpen: boolean;
    /** العنصر الحالي في النموذج */
    item: Membership | null;
    /** تعيين العنصر الحالي */
    setItem?: (value: any | null) => void;

    /** هل وضع الترجمة مفعل */
    isTranslate: boolean;
    /** فتح نافذة الترجمة لعنصر */
    openTranslate?: (item: any) => void;
    /** تعيين حالة الترجمة */
    setIsTranslate?: (value: boolean) => void;

    /** فتح نافذة إنشاء عنصر جديد */
    openCreate?: () => void;
    /** فتح نافذة تعديل عنصر */
    openEdit?: (item: any) => void;
    /** إغلاق النموذج */
    close?: () => void;
}
