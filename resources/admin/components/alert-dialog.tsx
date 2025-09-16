import {
    AlertDialog,
    AlertDialogCancel,
    AlertDialogContent,
    AlertDialogDescription,
    AlertDialogFooter,
    AlertDialogHeader,
    AlertDialogTitle,
} from "@/components/ui/alert-dialog"
import AlertConfirmContext from "@/context/AlertConfirmContext";
import { Button } from "@headlessui/react";
import { LoaderCircle } from "lucide-react";
import { useContext, useState } from "react";

export function AlertDialogDemo() {
    const { isOpen, setIsOpen, item, onConfirm } = useContext(AlertConfirmContext);
    const [isProcessing, setIsProcessing] = useState(false);
    if(item === null) return null;
    return (
        <AlertDialog open={isOpen} onOpenChange={setIsOpen}>
            <AlertDialogContent dir="rtl" className="rtl *:rtl:!text-right">
                <AlertDialogHeader>
                    <AlertDialogTitle>تأكيد حذف ({item.name ?? item.title ?? 'العنصر'})</AlertDialogTitle>
                    <AlertDialogDescription>
                        هل أنت متأكد أنك تريد حذف ({item.name ?? item.title ?? 'هذا العنصر'}) ؟ لا يمكن التراجع عن هذا الإجراء.
                    </AlertDialogDescription>
                </AlertDialogHeader>
                <AlertDialogFooter>
                    <AlertDialogCancel disabled={isProcessing}>الغاء</AlertDialogCancel>
                    <Button
                        onClick={async () => {
                            setIsProcessing(true);
                            await onConfirm();
                            setIsProcessing(false);
                        }}
                        disabled={isProcessing}
                        className="h-9 px-4 py-2 has-[>svg]:px-3 bg-primary text-primary-foreground shadow-xs hover:bg-primary/90 inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium transition-[color,box-shadow] disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg:not([class*='size-'])]:size-4 [&_svg]:shrink-0 outline-none focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px] aria-invalid:ring-destructive/20 dark:aria-invalid:ring-destructive/40 aria-invalid:border-destructive"
                    >
                        موافق
                        {isProcessing &&(
                            <LoaderCircle className="h-4 w-4 animate-spin" />
                        )}
                    </Button>
                </AlertDialogFooter>
            </AlertDialogContent>
        </AlertDialog>
    )
}
export default AlertDialogDemo;
