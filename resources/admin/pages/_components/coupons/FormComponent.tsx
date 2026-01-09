import InputError from "@/components/input-error";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
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
import { Select, SelectContent, SelectGroup, SelectItem, SelectLabel, SelectTrigger, SelectValue } from "@/components/ui/select";
import OpenFormContext from "@/context/OpenFormContext";
import InputField from "@/components/InputField";
import { Form } from "@inertiajs/react";
import { LoaderCircleIcon, RefreshCw } from "lucide-react";
import { useContext, useEffect, useRef, useState } from "react";
import { toast } from "sonner";
import { store, update } from "@/routes/admin/coupons";
import { DateTimePicker } from "@/components/ui/date-time-picker";

function FormBody({ formRef, formProps, item, resetAndClose }: any) {
    const [code, setCode] = useState<string>(item?.code ?? "");

    useEffect(() => {
        setCode(item?.code ?? "");
    }, [item]);

    const generateCode = () => {
        const chars = "ABCDEFGHJKLMNPQRSTUVWXYZ23456789"; // أرقام وحروف بدون لبس
        const random = Array.from({ length: 8 }, () => chars[Math.floor(Math.random() * chars.length)]).join("");
        const newCode = random;
        setCode(newCode);
    };

    return (
        <Form
            ref={formRef}
            {...formProps}
            disableWhileProcessing
            options={{ preserveScroll: true, preserveState: true, preserveUrl: true, replace: false }}
            onSuccess={resetAndClose}
            onError={(errors) => Object.entries(errors).forEach(([field, message]) => toast.error(`${field}: ${message}`))}
            className="max-w-2xl"
        >
            {({ processing, errors }) => (
                <>
                    <div className="grid gap-4 scrollbar !overflow-hidden hover:!overflow-y-auto max-h-[calc(100vh-230px)] p-1">
                        <div className="grid gap-3">
                            <Label htmlFor="code" className="required-label">كود الكوبون</Label>
                            <div className="relative">
                                <Input
                                    id="code"
                                    name="code"
                                    value={code}
                                    onChange={(e) => setCode(e.target.value.toUpperCase())}
                                    required
                                    className="pl-12"
                                />
                                <Button
                                    type="button"
                                    variant="ghost"
                                    size="icon"
                                    className="absolute inset-y-0 left-1 my-auto h-8 w-8 text-muted-foreground cursor-pointer"
                                    onClick={generateCode}
                                    aria-label="توليد كود"
                                >
                                    <RefreshCw className="h-4 w-4" />
                                </Button>
                            </div>
                            <InputError message={errors.code} />
                        </div>

                        <div className="grid gap-3">
                            <Label htmlFor="discount_type" className="required-label">نوع الخصم</Label>
                            <Select id="discount_type" name="discount_type" dir="rtl" defaultValue={item?.discount_type ?? "percent"} required>
                                <SelectTrigger className="w-full">
                                    <SelectValue placeholder="اختر نوع الخصم" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectGroup>
                                        <SelectLabel>نوع الخصم</SelectLabel>
                                        <SelectItem value="percent">نسبة مئوية</SelectItem>
                                        <SelectItem value="fixed">مبلغ ثابت</SelectItem>
                                    </SelectGroup>
                                </SelectContent>
                            </Select>
                            <InputError message={errors.discount_type} />
                        </div>

                        <InputField
                            label="قيمة الخصم"
                            id="value"
                            name="value"
                            type="number"
                            min={1}
                            defaultValue={item?.value ?? ""}
                            required
                            description="إذا كان الخصم نسبة مئوية، استخدم قيمة بين 1 و 100. للمبلغ الثابت استخدم الريال."
                            errors={errors}
                        />

                        <div className="grid gap-3">
                            <Label htmlFor="applies_to" className="required-label">يطبق على</Label>
                            <Select id="applies_to" name="applies_to" dir="rtl" defaultValue={item?.applies_to ?? "all"} required>
                                <SelectTrigger className="w-full">
                                    <SelectValue placeholder="اختر نطاق التطبيق" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectGroup>
                                        <SelectLabel>النطاق</SelectLabel>
                                        <SelectItem value="all">الكل</SelectItem>
                                        <SelectItem value="event">الفعاليات</SelectItem>
                                        <SelectItem value="membership">العضويات</SelectItem>
                                        <SelectItem value="library">المكتبة</SelectItem>
                                    </SelectGroup>
                                </SelectContent>
                            </Select>
                            <InputError message={errors.applies_to} />
                        </div>

                        <InputField
                            label="الحد الأقصى للاستخدام"
                            id="max_uses"
                            name="max_uses"
                            type="number"
                            min={1}
                            defaultValue={item?.max_uses ?? ""}
                            description="اتركه فارغًا للسماح بعدد غير محدود."
                            errors={errors}
                        />

                        <div className="grid gap-3">
                            <Label htmlFor="starts_at">يبدأ في</Label>
                            <DateTimePicker
                                id="starts_at"
                                name="starts_at"
                                value={item?.starts_at ? new Date(item.starts_at) : undefined}
                            />
                            <InputError message={errors.starts_at} />
                        </div>

                        <div className="grid gap-3">
                            <Label htmlFor="expires_at">ينتهي في</Label>
                            <DateTimePicker
                                id="expires_at"
                                name="expires_at"
                                value={item?.expires_at ? new Date(item.expires_at) : undefined}
                            />
                            <InputError message={errors.expires_at} />
                        </div>
                    </div>

                    <DialogFooter className="mt-2">
                        <DialogClose asChild>
                            <Button type="reset" variant="outline">الغاء</Button>
                        </DialogClose>
                        <Button type="submit" disabled={processing}>
                            {processing && <LoaderCircleIcon className="h-4 w-4 animate-spin" />}
                            {item ? "تحديث الكوبون" : "حفظ الكوبون"}
                        </Button>
                    </DialogFooter>
                </>
            )}
        </Form>
    );
}

function FormComponent({ tableHook }: { tableHook: any }) {
    const { item, isOpen, setOpen } = useContext(OpenFormContext);
    const formRef = useRef<any>(null);
    const { addRow, updateRow } = tableHook;

    const formProps = item
        ? update.form(item.id)
        : store.form();

    const resetAndClose = (page?: any) => {
        formRef.current?.reset();
        if (page?.props?.coupon?.coupon) {
            const coupon = page.props.coupon.coupon as CouponModel;
            item ? updateRow(coupon) : addRow(coupon);
        }
        setOpen?.(false);
    };

    return (
        <Dialog open={isOpen} onOpenChange={(open) => !open && resetAndClose()}>
            <DialogContent className="h-[90%]">
                <DialogHeader className="mb-4">
                    <DialogTitle>
                        {item ? `تعديل الكوبون: ${item?.code}` : "إضافة كوبون جديد"}
                    </DialogTitle>
                    <DialogDescription>
                        {item ? `قم بتحديث بيانات الكوبون "${item?.code}" بعناية.` : "أضف كوبون خصم جديد."}
                    </DialogDescription>
                </DialogHeader>

                <FormBody
                    formRef={formRef}
                    formProps={formProps}
                    item={item}
                    resetAndClose={resetAndClose}
                />
            </DialogContent>
        </Dialog>
    );
}

export default FormComponent;
