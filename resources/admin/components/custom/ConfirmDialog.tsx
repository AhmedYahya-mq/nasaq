import React from "react";
import { createRoot } from "react-dom/client";
import {
    AlertDialog,
    AlertDialogAction,
    AlertDialogCancel,
    AlertDialogContent,
    AlertDialogDescription,
    AlertDialogFooter,
    AlertDialogHeader,
    AlertDialogTitle,
} from "@/components/ui/alert-dialog";
import { Button } from "@/components/ui/button";

export function confirmAlertDialog({ title, description }: { title: string, description?: string }): Promise<boolean> {
    // تحقق من وجود الـ div المخصص
    const container = document.querySelector<HTMLDivElement>("#confirm-dialog");
    if (!container) return Promise.resolve(false); // لا يوجد مكان لعرض Dialog
    if (container.hasChildNodes()) return Promise.resolve(false); // Dialog موجود مسبقًا

    return new Promise((resolve) => {
        const root = createRoot(container);

        const handleClose = (result: boolean) => {
            root.unmount();
            resolve(result);
        };

        const ConfirmDialog: React.FC = () => (
            <AlertDialog open onOpenChange={() => handleClose(false)}>
                <AlertDialogContent className="*:rtl:!text-right">
                    <AlertDialogHeader>
                        <AlertDialogTitle>{title}</AlertDialogTitle>
                        {description && <AlertDialogDescription>{description}</AlertDialogDescription>}
                    </AlertDialogHeader>
                    <AlertDialogFooter className="flex gap-2 justify-end">
                        <AlertDialogCancel asChild>
                            <Button className="!badget-red-500" onClick={() => handleClose(false)}>إلغاء</Button>
                        </AlertDialogCancel>
                        <AlertDialogAction asChild>
                            <Button variant="destructive" onClick={() => handleClose(true)}>تأكيد</Button>
                        </AlertDialogAction>
                    </AlertDialogFooter>
                </AlertDialogContent>
            </AlertDialog>
        );

        root.render(<ConfirmDialog />);
    });
}


export function ConfirmInDiv() {
    return <div id="confirm-dialog"></div>;
}
