"use client"

import { useState } from "react"
import AlertConfirmContext from "@/context/AlertConfirmContext"
import AlertDialogDemo from "@/components/alert-dialog"
import { AlertConfirmContextType } from "@/types/context"

const AlertConfirmProvider = ({ children }: { children: React.ReactNode }) => {
    const [isOpen, setIsOpen] = useState(false)
    const [item, setItem] = useState<any | null>(null)
    const [deleteCallback, setDeleteCallback] = useState<(() => Promise<boolean>) | null>(null)

    /**
     * فتح نافذة التأكيد وتعيين دالة الحذف والعنصر المستهدف
     * @param fn دالة الحذف التي يجب تنفيذها عند التأكيد (ترجع Promise<boolean>)
     * @param targetItem العنصر المستهدف للحذف (اختياري)
     * @return void
     */
    const handleDelete = (fn: () => Promise<boolean>, targetItem?: any) => {
        setDeleteCallback(() => fn)
        if (targetItem) setItem(targetItem)
        setIsOpen(true)
    }


    /**
     * تنفيذ دالة الحذف عند التأكيد وإغلاق النافذة إذا نجح الحذف
     * @return Promise<void>
     */
    const onConfirm = async () => {
        let isSuccess = false;
        if (deleteCallback) {
            isSuccess = await deleteCallback();
        }
        if (!isSuccess) return;
        setDeleteCallback(null);
        setItem(null);
        setIsOpen(false);
    }

    const value: AlertConfirmContextType = {
        isOpen,
        setIsOpen,
        handleDelete,
        onConfirm,
        item,
        setItem,
    }
    return (
        <AlertConfirmContext.Provider value={value}>
            {children}
            <AlertDialogDemo />
        </AlertConfirmContext.Provider>
    )
}

export default AlertConfirmProvider
