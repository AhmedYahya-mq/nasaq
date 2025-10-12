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
import InputPassword from "@/components/ui/InputPassword";
import { Label } from "@/components/ui/label";
import PhoneInput from "@/components/ui/PhoneInput";
import { Popover, PopoverContent, PopoverTrigger } from "@/components/ui/popover";
import {
    Select,
    SelectContent,
    SelectGroup,
    SelectItem,
    SelectLabel,
    SelectTrigger,
    SelectValue,
} from "@/components/ui/select";
import OpenFormContext from "@/context/OpenFormContext";
import { Form } from "@inertiajs/react";
import { CalendarIcon, LoaderCircleIcon } from "lucide-react";
import { useContext, useEffect, useRef, useState } from "react";
import { toast } from "sonner";
import { format, set } from "date-fns";
import { Calendar } from "@/components/ui/calendar";
import { Resource } from "@/types/model/resources";
import FileUpload from "./FileUpload";
import { store, update } from "@/routes/admin/library";
import { translation } from "@/routes/admin/library/update";
import { translateField } from "@/lib/utils";
import StudioImages from "@/components/custom/studio-images/StudioImages";
import { ImageItem } from "@/types/model/photo";

function FormComponent({ tableHook }: { tableHook: any }) {
    const { item, isTranslate, setIsTranslate, isOpen, setOpen } = useContext(OpenFormContext) as { item: Resource, isTranslate: any, setIsTranslate: any, isOpen: any, setOpen: any };
    const formRef = useRef<any>(null);
    const { addRow, updateRow } = tableHook;
    const [date, setDate] = useState<Date | undefined>(item?.published_at ? new Date(item.published_at) : undefined);
    const [uploadDisabled, setUploadDisabled] = useState(false);
    const [filePath, setFilePath] = useState<string>(item?.path || "");
   const [poster, setPoster] = useState<ImageItem | null>(item?.poster || null);
    const [isOpened, setIsOpened] = useState(isOpen);

    // إعادة ضبط التاريخ عند تغيير العنصر
    useEffect(() => {
        setDate(item?.published_at ? new Date(item.published_at) : undefined);
        setFilePath(item?.path || "");
        setPoster(item?.poster || null);
    }, [item]);

    const formProps = item
        ? isTranslate ? translation.form(item.ulid) : update.form(item.ulid)
        : store.form();
    const resetAndClose = (page?: any) => {
        formRef.current?.reset();
        if (page?.props?.resource) {
            const resource = page.props.resource as Resource;
            item ? updateRow(resource) : addRow(resource);
        }
        setIsTranslate?.(false);
        setOpen?.(false);
        setPoster(null);
    };

    // دالة مساعدة لحقول الإدخال
    const renderInput = (
        id: string,
        name: string,
        label: string,
        value?: string,
        type = "text",
        required = false,
        props: any = {},
        errors: Record<string, string> = {}
    ) => (
        <div className="grid gap-3">
            <Label htmlFor={id} className={required ? "required-label" : ""}>
                {label}
            </Label>

            {type === "tel" ? (
                <PhoneInput id={id} name={name} defaultValue={value} required={required} />
            ) : type === "password" ? (
                <InputPassword id={id} name={name} />
            ) : (
                <Input
                    id={id}
                    name={name}
                    type={type}
                    defaultValue={value}
                    required={required}
                    {...props}
                />
            )}

            <InputError message={errors[name]} />
        </div>
    );


    return (
        <Dialog open={isOpen} onOpenChange={(open) => !open && resetAndClose()}>
            <DialogContent className="sm:max-w-[425px]">
                <DialogHeader className="mb-4">
                    <DialogTitle>{item ? `تعديل المورد: ${item.title}` : "إضافة المورد جديدة"}</DialogTitle>
                    <DialogDescription>{item ? `قم بتحديث بيانات المورد "${item.title}" بعناية.` : "أضف المورد جديد بسهولة وسرعة."}</DialogDescription>
                </DialogHeader>

                <Form
                    ref={formRef}
                    {...formProps}
                    disableWhileProcessing
                    headers={{ 'X-Locale': isTranslate ? 'en' : 'ar' }}
                    onSuccess={resetAndClose}
                    transform={data => ({ ...data, published_at: date })}
                    options={{ preserveScroll: true, preserveState: true, preserveUrl: true, replace: false }}
                    onError={(errors) => Object.entries(errors).forEach(([field, message]) => toast.error(`${field}: ${message}`))}
                    className="max-w-2xl"
                >
                    {({ processing, errors }) => (
                        <>
                            <div className="grid gap-4 scrollbar !overflow-hidden hover:!overflow-y-auto max-h-[calc(100vh-230px)] p-1">
                                {renderInput("name-1", "title", "عنوان", translateField(item, "title", isTranslate), "text", true)}
                                {renderInput("description-1", "description", "وصف", translateField(item, "description", isTranslate), "text", true)}
                                {renderInput("author-1", "author", "النأشر", translateField(item, "author", isTranslate), "text", true)}
                                {
                                    !isTranslate && (
                                        <>
                                            <div className="grid gap-3">
                                                <Label htmlFor="status-1" className="required-label">الحالة</Label>
                                                <Select name="status" dir="rtl" defaultValue={item?.status.value || "draft"} required>
                                                    <SelectTrigger id="status-1">
                                                        <SelectValue placeholder="اختر الحالة المصدر..." />
                                                    </SelectTrigger>
                                                    <SelectContent>
                                                        <SelectGroup>
                                                            <SelectLabel>الحالة المصدر</SelectLabel>
                                                            <SelectItem value="draft">مسودة</SelectItem>
                                                            <SelectItem value="published">منشور</SelectItem>
                                                        </SelectGroup>
                                                    </SelectContent>
                                                </Select>
                                                <InputError message={errors.status} />
                                            </div>
                                            <div className="grid gap-3">
                                                <Label htmlFor="published_at-1">تاريخ النشر</Label>
                                                <Popover>
                                                    <PopoverTrigger asChild>
                                                        <Button
                                                            variant="outline"
                                                            data-empty={!date}
                                                            className="data-[empty=true]:text-muted-foreground w-[280px] justify-start text-left font-normal"
                                                        >
                                                            <CalendarIcon />
                                                            <span className="ml-2">{date ? format(date, "yyyy-MM-dd") : "اختر التاريخ"}</span>
                                                        </Button>
                                                    </PopoverTrigger>
                                                    <PopoverContent className="w-auto p-0">
                                                        <Calendar mode="single" selected={date} onSelect={setDate} />
                                                    </PopoverContent>
                                                </Popover>
                                                <InputError message={errors.published_at} />
                                            </div>
                                            <div className="grid gap-3">
                                                <Label htmlFor="type-1" className="required-label">النوع</Label>
                                                <Select name="type" dir="rtl" defaultValue={item?.type.value || "ebook"} required>
                                                    <SelectTrigger id="type-1">
                                                        <SelectValue placeholder="اختر النوع..." />
                                                    </SelectTrigger>
                                                    <SelectContent>
                                                        <SelectGroup>
                                                            <SelectItem value="ebook">
                                                                كتاب إلكتروني
                                                            </SelectItem>
                                                            <SelectItem value="audio">
                                                                صوتي
                                                            </SelectItem>
                                                            <SelectItem value="video">
                                                                فيديو
                                                            </SelectItem>
                                                            <SelectItem value="article">
                                                                مقالة
                                                            </SelectItem>
                                                            <SelectItem value="research_paper">
                                                                ورقة بحثية
                                                            </SelectItem>
                                                            <SelectItem value="tutorial">
                                                                درس تعليمي
                                                            </SelectItem>
                                                        </SelectGroup>
                                                    </SelectContent>
                                                </Select>
                                                <InputError message={errors.status} />
                                            </div>
                                            {renderInput("price-1", "price", "السعر", item?.price ? item.price.toString() : "0", "number", false, { min: 0 })}
                                            {renderInput("discount-1", "discount", "الخصم (%)", item?.discount ? item.discount.toString() : "0", "number", false, { max: 100, min: 0 })}
                                            <div className="grid gap-3">
                                                <Label htmlFor="file-upload-1" className="required-label">رفع الملف</Label>
                                                <FileUpload
                                                    onUploaded={(path) => setFilePath(path)}
                                                    disabled={uploadDisabled}
                                                    setDisabled={setUploadDisabled}
                                                />
                                                <Input type="hidden" name="path" value={filePath} />
                                                <InputError message={errors.path} />
                                            </div>
                                            <div className="grid gap-3">
                                                <Label htmlFor="poster-upload-1">رفع صورة الغلاف</Label>
                                                <StudioImages
                                                    isOpen={isOpened}
                                                    isMulti={false}
                                                    onClose={setIsOpened}
                                                    onImageSelect={
                                                        function (image: ImageItem | ImageItem[]): void {
                                                            if (!Array.isArray(image)) {
                                                                setPoster(image);
                                                            }
                                                        }
                                                    } />
                                                <Button type="button" variant="outline" onClick={() => setIsOpened(true)}>اختر من الاستوديو</Button>
                                                <Input type="hidden" name="poster" value={poster?.id} />
                                                {/* عرض صوره التي اختاره */}
                                                {(poster) && <img src={poster?.url} alt="Poster" className="mt-2 h-32 object-contain" />}
                                                <InputError message={errors.poster} />
                                            </div>
                                        </>
                                    )
                                }
                            </div>

                            <DialogFooter className="mt-2">
                                <DialogClose asChild>
                                    <Button type="reset" className="cursor-pointer disabled:opacity-75" disabled={uploadDisabled} variant="outline">إلغاء</Button>
                                </DialogClose>
                                <Button type="submit" className="cursor-pointer disabled:bg-primary/85" disabled={processing || uploadDisabled}>
                                    {processing && <LoaderCircleIcon className="h-4 w-4 animate-spin mr-2" />}
                                    {item ? "تحديث المورد" : "حفظ المورد"}
                                </Button>
                            </DialogFooter>
                        </>
                    )}
                </Form>
            </DialogContent>
        </Dialog>
    );
}

export default FormComponent;
