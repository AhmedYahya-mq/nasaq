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
import { Label } from "@/components/ui/label";
import { Textarea } from "@/components/ui/textarea";
import OpenFormContext from "@/context/OpenFormContext";
import { getErrorMessage, translateField } from "@/lib/utils";
import { Form } from "@inertiajs/react";
import { LoaderCircleIcon } from "lucide-react";
import { useContext, useEffect, useRef, useState } from "react";
import { toast } from "sonner";
import { store, update } from "@/routes/admin/events";
import { DateTimePicker } from "@/components/ui/date-time-picker";
import { addDays } from "date-fns";
import { translation } from "@/routes/admin/events/update";
import { Membership } from "@/types/model/membership";
import axios from "axios";
import { memberships as membership } from "@/routes/admin";;
import { MembershipSelect } from "./MembershipSelect";
import { Select, SelectContent, SelectGroup, SelectItem, SelectLabel, SelectTrigger, SelectValue } from "@/components/ui/select";
import InputField from "@/components/InputField";



// --- Component for reusable textarea field ---
const TextareaField = ({ label, id, name, required = false, defaultValue, errors }: any) => (
    <div className="grid gap-3">
        <Label htmlFor={id} className={required ? "required-label" : ""}>{label}</Label>
        <Textarea className="scrollbar" id={id} name={name} defaultValue={defaultValue || ""} required={required} />
        <InputError message={errors?.[name]} />
    </div>
);

// --- Component for category select ---
const SelectCategory = ({ defaultValue }: { defaultValue?: string }) => (
    <Select defaultValue={defaultValue} dir="rtl" id="event_category" name="event_category" required>
        <SelectTrigger className="w-full">
            <SelectValue placeholder="أختر فئة الحدث" />
        </SelectTrigger>
        <SelectContent>
            <SelectGroup>
                <SelectLabel>فئات</SelectLabel>
                <SelectItem value="Workshop">ورشة عمل</SelectItem>
                <SelectItem value="Seminar">ندوة</SelectItem>
                <SelectItem value="Lecture">محاضرة</SelectItem>
                <SelectItem value="Q&A Session">جلسة أسئلة وأجوبة</SelectItem>
                <SelectItem value="Field Visit">زيارة ميدانية</SelectItem>
            </SelectGroup>
        </SelectContent>
    </Select>
);

// --- Component for event type select داخل الفورم ---
function EventTypeSelect({ value, onChange }: { value: string, onChange: (val: string) => void }) {
    return (
        <div className="grid gap-3">
            <Label htmlFor="event_type" className="required-label">نوع الفعالية</Label>
            <Select id="event_type" dir="rtl" name="event_type" value={value} onValueChange={onChange} required>
                <SelectTrigger className="w-full">
                    <SelectValue placeholder="اختر نوع الفعالية" />
                </SelectTrigger>
                <SelectContent>
                    <SelectGroup >
                        <SelectLabel>أنواع الفعالية</SelectLabel>
                        <SelectItem value="virtual">افتراضية</SelectItem>
                        <SelectItem value="physical">فيزيائية</SelectItem>
                    </SelectGroup>
                </SelectContent>
            </Select>
        </div>
    );
}

// --- Form Body ---
function FormBody({ formRef, formProps, item, isTranslate, memberships, resetAndClose }: any) {
    const [eventType, setEventType] = useState(item?.event_type.value || "virtual");
    const [acceptedMembership, setAcceptedMembership] = useState<number[]>(item?.membership_ids ?? [0]);

    return (
        <Form
            ref={formRef}
            {...formProps}
            disableWhileProcessing
            headers={{ 'X-Locale': isTranslate ? 'en' : 'ar' }}
            onSuccess={resetAndClose}
            transform={data => ({ ...data, accepted_membership_ids: acceptedMembership })}
            translate="yes"
            options={{ preserveScroll: true, preserveState: true, preserveUrl: true, replace: false }}
            onError={(errors) => Object.entries(errors).forEach(([field, message]) => toast.error(`${field}: ${message}`))}
            className="max-w-2xl"
        >
            {({ processing, errors }) => (
                <>
                    {
                        isTranslate ? (
                            <div className="grid gap-4 scrollbar !overflow-hidden hover:!overflow-y-auto max-h-[calc(100vh-230px)] p-1">
                                {/* عنوان الحدث */}
                                <InputField
                                    label="عنوان الحدث"
                                    id="title-1"
                                    name="title"
                                    required
                                    defaultValue={translateField(item, "title", isTranslate)}
                                    errors={errors}
                                />

                                {/* وصف الحدث */}
                                <TextareaField
                                    label="وصف الحدث"
                                    id="description-1"
                                    name="description"

                                    required
                                    defaultValue={translateField(item, "description", isTranslate)}
                                    errors={errors}
                                />

                                {eventType === "physical" && (
                                    <InputField
                                        label="العنوان (اختياري)"
                                        id="address"
                                        name="address"
                                        defaultValue={item?.address ?? ""}
                                        errors={errors}
                                    />
                                )}
                            </div>
                        ) : (
                            <div className="grid gap-4 scrollbar !overflow-hidden hover:!overflow-y-auto max-h-[calc(100vh-230px)] p-1">

                                {/* نوع الفعالية */}
                                <EventTypeSelect value={eventType} onChange={setEventType} />

                                {/* عنوان الحدث */}
                                <InputField
                                    label="عنوان الحدث"
                                    id="title-1"
                                    name="title"
                                    required
                                    defaultValue={translateField(item, "title", isTranslate)}
                                    errors={errors}
                                />

                                {/* وصف الحدث */}
                                <TextareaField
                                    label="وصف الحدث"
                                    id="description-1"
                                    name="description"
                                    required
                                    defaultValue={translateField(item, "description", isTranslate)}
                                    errors={errors}
                                />

                                {/* حقل العنوان يظهر فقط إذا كانت Physical */}
                                {eventType === "physical" && (
                                    <InputField
                                        label="العنوان (اختياري)"
                                        id="address"
                                        name="address"
                                        defaultValue={item?.address ?? ""}
                                        errors={errors}
                                    />
                                )}

                                {/* منصة الحدث تظهر فقط إذا كانت افتراضية */}
                                {eventType === "virtual" && (
                                    <div className="grid gap-3">
                                        <Label htmlFor="event_method" className="required-label">منصة الحدث</Label>
                                        <Select id="event_method" name="event_method" dir="rtl" defaultValue={item?.platform ?? "zoom"} required>
                                            <SelectTrigger className="w-full">
                                                <SelectValue placeholder="اختر المنصة" />
                                            </SelectTrigger>
                                            <SelectContent>
                                                <SelectGroup>
                                                    <SelectLabel>المنصات</SelectLabel>
                                                    <SelectItem value="zoom">Zoom</SelectItem>
                                                    <SelectItem value="google_meet">Google Meet</SelectItem>
                                                    <SelectItem value="microsoft_teams">Microsoft Teams</SelectItem>
                                                    <SelectItem value="other">أخرى</SelectItem>
                                                </SelectGroup>
                                            </SelectContent>
                                        </Select>
                                        <InputError message={errors.event_method} />
                                    </div>
                                )}


                                {/* باقي الحقول */}
                                <InputField
                                    label="سعر التسجيل (اختياري)"
                                    id="price"
                                    name="price"
                                    type="number"
                                    defaultValue={item?.price ?? ""}
                                    description="اترك هذا الحقل فارغًا أو ضع 0 لجعل التسجيل مجانيًا."
                                    errors={errors}
                                />

                                <InputField
                                    label="نسبة الخصم (%) (اختياري)"
                                    id="discount"
                                    name="discount"
                                    type="number"
                                    min={0}
                                    max={100}
                                    defaultValue={item?.discount ?? ""}
                                    description="أدخل نسبة الخصم بين 1 و 100. اترك هذا الحقل فارغًا أو ضع 0 إذا لم يكن هناك خصم."
                                    errors={errors}
                                />

                                <div className="grid gap-3">
                                    <Label htmlFor="membership_id" className="required-label">من يسجل</Label>
                                    <div className="flex flex-col gap-1">
                                        <MembershipSelect memberships={memberships} defaultValue={acceptedMembership} onChange={setAcceptedMembership} />
                                        <div className="text-sm text-muted-foreground">
                                            اختر من يستطيع تسجيل هذا الحدث. اختر "الكل" للسماح لجميع الأعضاء بالتسجيل، أو اختر عضويات محددة للسماح فقط لأعضاء تلك العضويات بالتسجيل.
                                        </div>
                                        <InputError message={errors.membership_id} />
                                    </div>
                                </div>

                                <div className="grid gap-3">
                                    <Label htmlFor="event_category" className="required-label">فئة الحدث</Label>
                                    <SelectCategory defaultValue={item?.event_category} />
                                    <InputError message={errors.event_category} />
                                </div>

                                <div className="grid gap-3">
                                    <Label htmlFor="start_at" className="required-label">تاريخ البداية</Label>
                                    <DateTimePicker
                                        id="start_at"
                                        name="start_at"
                                        value={item?.start_at ? new Date(item.start_at) : addDays(new Date(), 1)}
                                        disabled={(day: Date) => day < new Date()

                                        }
                                        required
                                    />
                                    <InputError message={errors.start_at} />
                                </div>

                                <InputField
                                    label="رابط الحدث (اختياري)"
                                    id="link"
                                    name="link"
                                    type="url"
                                    defaultValue={item?.link ?? ""}
                                    errors={errors}
                                    description={eventType === "virtual" ? "رابط الفعالية الافتراضية (مثل Zoom، Google Meet، إلخ)." : "رابط لمزيد من المعلومات عن الموقع (مثل خرائط جوجل)."}
                                />

                                <InputField
                                    label="السعة (اختياري)"
                                    id="capacity"
                                    name="capacity"
                                    type="number"
                                    defaultValue={item?.capacity ?? ""}
                                    errors={errors}
                                    description="اترك هذا الحقل فارغًا أو ضع 0 إذا لم يكن هناك حد للسعة."
                                />
                            </div>

                        )
                    }

                    <DialogFooter className="mt-2">
                        <DialogClose asChild>
                            <Button type="reset" variant="outline">الغاء</Button>
                        </DialogClose>
                        <Button type="submit" disabled={processing}>
                            {processing && <LoaderCircleIcon className="h-4 w-4 animate-spin" />}
                            {item ? "تحديث الحدث" : "حفظ الحدث"}
                        </Button>
                    </DialogFooter>
                </>
            )}
        </Form>
    );
}

// --- Main Form Component ---
function FormComponent({ tableHook }: { tableHook: any }) {
    const { item, isTranslate, setIsTranslate, isOpen, setOpen } = useContext(OpenFormContext);
    const formRef = useRef<any>(null);
    const { addRow, updateRow } = tableHook;
    const [memberships, setMemberships] = useState<Membership[]>([]);

    useEffect(() => {
        axios.get(membership().url)
            .then((res) => {
                setMemberships(res.data);
            })
            .catch((err) => toast.error(getErrorMessage(err)));
    }, []);

    const formProps = item
        ? isTranslate ? translation.form(item.ulid) : update.form(item.ulid)
        : store.form();

    const resetAndClose = (page?: any) => {
        formRef.current?.reset();
        if (page?.props?.event?.event) {
            const event = page.props.event.event;
            item ? updateRow(event, isTranslate) : addRow(event);
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
                            ? `ترجمة الحدث: ${item?.title}`
                            : item
                                ? `تعديل الحدث: ${item?.title}`
                                : "إضافة حدث جديد"}
                    </DialogTitle>
                    <DialogDescription>
                        {isTranslate
                            ? `قم بترجمة الحدث "${item?.title}" بعناية.`
                            : item
                                ? `قم بتحديث بيانات الحدث "${item?.title}" بعناية.`
                                : "أضف حدث جديد بسهولة وسرعة."}
                    </DialogDescription>
                </DialogHeader>

                <FormBody
                    formRef={formRef}
                    formProps={formProps}
                    item={item}
                    isTranslate={isTranslate}
                    memberships={memberships}
                    resetAndClose={resetAndClose}
                />
            </DialogContent>
        </Dialog>
    );
}

export default FormComponent;
