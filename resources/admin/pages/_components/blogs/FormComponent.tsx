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

import { Textarea } from "@/components/ui/textarea";
import OpenFormContext from "@/context/OpenFormContext";
import { translateField } from "@/lib/utils";
import { Membership } from "@/types/model/membership.d";
import { Form } from "@inertiajs/react";
import { LoaderCircleIcon } from "lucide-react";
import { useContext, useEffect, useRef, useState } from "react";

import { toast } from "sonner";
import { ImageItem } from "@/types/model/photo";
import StudioImages from "@/components/custom/studio-images/StudioImages";
import TiptapEditor from "@/components/tiptap/TiptapEditor";
import { updateTranslation } from "@/actions/App/Http/Controllers/User/BlogController";
import { store, update } from "@/routes/admin/blogs";



function FormComponent({ tableHook }: { tableHook: any }) {
    const { item, isTranslate, setIsTranslate, isOpen, setOpen } =
        useContext(OpenFormContext);
    const formRef = useRef<any>(null);
    const { addRow, updateRow } = tableHook;
    const [image, setImage] = useState<ImageItem | null>(item?.image || null);
    const [isStudioOpen, setIsStudioOpen] = useState<boolean | null>(false);
    const [content, setContent] = useState<string>(item?.content || "");

    useEffect(() => {
        if (item?.image) {
            setImage(item.image);
        }
        if (item?.content) {
            setContent(item.content);
        }
    }, [item]);
    const formProps = (() => {
        if (isTranslate && item) {
            return updateTranslation.form(item.id);
        } else if (item) {
            return update.form(item.id);
        } else {
            return store.form();
        }
    })();


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
            <DialogContent className="h-[95%]">
                <DialogHeader className="mb-4">
                    <DialogTitle>
                        {isTranslate
                            ? `ترجمة المدونة: ${item?.title}`
                            : item
                                ? `تعديل المدونة: ${item.title}`
                                : "إضافة المدونة جديدة"}
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
                    {...formProps}
                    disableWhileProcessing
                    headers={{
                        'X-Locale': isTranslate ? 'en' : 'ar',
                    }}
                    onSuccess={resetAndClose}
                    translate="yes"
                    transform={data => {
                        if (!content || content.trim() === "") {
                            toast.error("حقل المحتوى لا يمكن أن يكون فارغًا!");
                            throw new Error("Content is required");
                        }
                        return { ...data, content };
                    }}
                    options={{
                        preserveScroll: true,
                        preserveState: true,
                        preserveUrl: true,
                        replace: false,
                    }}
                    onError={(errors) => {
                        Object.entries(errors).forEach(([field, message]) => {
                            toast.error(`${field}: ${message}`);
                        });
                    }}
                    className="max-w-2xl"
                >
                    {({ processing, errors }) => (
                        <>
                            <div className="grid gap-4 scrollbar !overflow-hidden hover:!overflow-y-auto max-h-[calc(100vh-230px)] p-1">
                                {/* الاسم */}
                                <div className="grid gap-3">
                                    <Label htmlFor="title-1" className="required-label">
                                        عنوان المدونة
                                    </Label>
                                    <Input
                                        id="title-1"
                                        name="title"
                                        defaultValue={translateField(item!, "title", isTranslate)}
                                        required
                                    />
                                    <InputError message={errors.title} />
                                </div>
                                <div className="grid gap-3">
                                    <Label htmlFor="excerpt-1" className="required-label">
                                        ملخص المدونة
                                    </Label>
                                    <Textarea
                                        id="excerpt-1"
                                        name="excerpt"
                                        rows={4}
                                        maxLength={255}
                                        className="max-h-32"
                                        placeholder="اكتب ملخصًا قصيرًا للمدونة (حتى 255 حرفًا)"
                                        defaultValue={translateField(item!, "excerpt", isTranslate)}
                                        required
                                    />
                                    <InputError message={errors.excerpt} />
                                </div>

                                <div className={`grid gap-3 ${isTranslate ? "hidden" : ""}`}>
                                    <Label htmlFor="photo-1" className="required-label">
                                        صورة المدونة
                                    </Label>
                                    <div id="photo-1" onClick={() => setIsStudioOpen(true)} className="w-full h-48 border-dashed border-2 rounded-md flex items-center justify-center overflow-hidden bg-accent/30">
                                        {image ? (
                                            <img
                                                src={image.url}
                                                alt={image.name ?? `Image ${image.name}`}
                                                className="w-full h-full object-cover"
                                                loading="lazy"
                                                draggable={false}
                                                onError={(e) => {
                                                    (e.target as HTMLImageElement).src = "/images/image-placeholder.png";
                                                }}
                                            />
                                        ) : (
                                            <span className="text-muted-foreground">لا توجد صورة مختارة</span>
                                        )}
                                    </div>
                                    <Input
                                        type="hidden"
                                        name="image_id"
                                        value={image ? image.id : ""}
                                    />
                                    <div className="text-sm text-muted-foreground">
                                        {image
                                            ? `الصورة المختارة: ${image.name ?? `Image ${image.id}`}`
                                            : "لا يمكن  ترك الصورة فارغة."}
                                    </div>
                                    <StudioImages
                                        isOpen={isStudioOpen ?? false}
                                        onClose={setIsStudioOpen}
                                        onImageSelect={(img) => {
                                            setImage(img as ImageItem);
                                        }} isMulti={false} />
                                    <InputError message={errors.excerpt} />
                                </div>

                                {/* المحتوى */}
                                <div className="grid gap-3">
                                    <Label htmlFor="content-1" className="required-label">
                                        محتوى المدونة
                                    </Label>
                                    <TiptapEditor
                                        value={translateField(item!, "content", isTranslate) || ""}
                                        onChange={(val) => {
                                            setContent(val);
                                        }}
                                    />
                                    <InputError message={errors.content} />
                                </div>
                            </div>

                            <DialogFooter className="mt-2">
                                <DialogClose asChild>
                                    <Button type="reset" variant="outline">
                                        الغاء
                                    </Button>
                                </DialogClose>
                                <Button type="submit" className="cursor-pointer" disabled={processing}>
                                    {processing && <LoaderCircleIcon className="h-4 w-4 animate-spin " />}
                                    {isTranslate
                                        ? `ترجمة المدونة`
                                        : item
                                            ? "تحديث المدونة"
                                            : "حفظ المدونة"}
                                </Button>
                            </DialogFooter>
                        </>
                    )}
                </Form>
            </DialogContent>
        </Dialog >
    );
}

export default FormComponent;
