import InputError from "@/components/input-error";
import { Button } from "@/components/ui/button";
import {
    Dialog,
    DialogClose,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
} from "@/components/ui/dialog";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import {
    Select,
    SelectContent,
    SelectGroup,
    SelectItem,
    SelectLabel,
    SelectTrigger,
    SelectValue,
} from "@/components/ui/select";
import { Textarea } from "@/components/ui/textarea";
import OpenFormContext from "@/context/OpenFormContext";
import { translateField } from "@/lib/utils";
import { store, update } from "@/routes/admin/membership";
import { Membership } from "@/types/model/membership.d";
import { Form } from "@inertiajs/react";
import { LoaderCircleIcon } from "lucide-react";
// Removed missing @inertiajs/core types; Page can be imported from @inertiajs/react if needed
import { useContext, useEffect, useRef, useState } from "react";
import DynamicInputList from "../ui/DynamicInputList";
import { updateTranslation } from "@/actions/App/Http/Controllers/User/MembershipController";
import { toast } from "sonner";
import FileUploader from "@/components/FileUploader";
import TiptapEditor from "@/components/tiptap/TiptapEditor";



function FormComponent({ tableHook }: { tableHook: any }) {
    const { item, isTranslate, setIsTranslate, isOpen, setOpen } =
        useContext(OpenFormContext);
    const formRef = useRef<any>(null);
    const [numRequired, setNumRequired] = useState(1);
    const [numFeatures, setNumFeatures] = useState(1);
    const { addRow, updateRow } = tableHook;
    const formProps = (() => {
        if (isTranslate && item) {
            return updateTranslation.form(item.id);
        } else if (item) {
            return update.form(item.id);
        } else {
            return store.form();
        }
    })();


    useEffect(() => {
        setNumRequired(item?.requirements?.length ?? 1);
        setNumFeatures(item?.features?.length ?? 1);
    }, [item]);

    const resetAndClose = (page?: any) => {
        formRef.current?.reset();
        if (page?.props?.membership) {
            const membership = page.props.membership as Membership;
            item ? updateRow(membership, isTranslate) : addRow(membership);
        }
        setIsTranslate?.(false);
        setOpen?.(false);
    };

    return (
        <Dialog open={isOpen} onOpenChange={(open) => !open && resetAndClose()}>
            <DialogContent className="min-w-[95%] h-[95%]">
                <DialogHeader className="mb-4">
                    <DialogTitle>
                        {isTranslate
                            ? `ترجمة المدونة: ${item?.title}`
                            : item
                                ? `تعديل المدونة: ${item.title}`
                                : "إضافة عضوية جديدة"}
                    </DialogTitle>
                    <DialogDescription>
                        {isTranslate
                            ? `قم بترجمة المدونة "${item?.title}" بعناية.`
                            : item
                                ? `قم بتحديث بيانات المدونة "${item.title}" بعناية.`
                                : "أضف مدونة جديدة بسهولة وسرعة."}
                    </DialogDescription>
                </DialogHeader>
                <Form
                    ref={formRef}
                    method={formProps.method}
                    action={formProps.action}
                    onSuccess={resetAndClose}
                    className="space-y-4 scrollbar h-full"
                >
                    <TiptapEditor
                    maxHeight={300}
                    minHeight={300} />
                </Form>
            </DialogContent>
        </Dialog >
    );
}

export default FormComponent;
