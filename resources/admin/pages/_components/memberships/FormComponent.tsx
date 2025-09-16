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
// Removed unused @inertiajs/core types (use @inertiajs/react Page if needed)
import { useContext, useEffect, useRef, useState } from "react";
import DynamicInputList from "../ui/DynamicInputList";
import { updateTranslation } from "@/actions/App/Http/Controllers/User/MembershipController";
import { toast } from "sonner";



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
            <DialogContent className="sm:max-w-[425px]">
                <DialogHeader className="mb-4">
                    <DialogTitle>
                        {isTranslate
                            ? `ترجمة العضوية: ${item?.name}`
                            : item
                                ? `تعديل العضوية: ${item.name}`
                                : "إضافة عضوية جديدة"}
                    </DialogTitle>
                    <DialogDescription>
                        {isTranslate
                            ? `قم بترجمة العضوية "${item?.name}" بعناية.`
                            : item
                                ? `قم بتحديث بيانات العضوية "${item.name}" بعناية.`
                                : "أضف عضوية جديدة بسهولة وسرعة."}
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
                                    <Label htmlFor="name-1" className="required-label">
                                        أسم العضوية
                                    </Label>
                                    <Input
                                        id="name-1"
                                        name="name"
                                        defaultValue={translateField(item!, "name", isTranslate)}
                                        required
                                    />
                                    <InputError message={errors.name} />
                                </div>

                                {/* السعر والمدة */}
                                {!isTranslate && (
                                    <>
                                        <div className="grid gap-3">
                                            <Label htmlFor="membership-price" className="required-label">
                                                سعر العضوية
                                            </Label>
                                            <Input
                                                id="membership-price"
                                                type="number"
                                                min="0"
                                                placeholder="500"
                                                required
                                                name="price"
                                                defaultValue={item?.price}
                                            />
                                            <InputError message={errors.price} />
                                        </div>

                                        <div className="grid gap-3">
                                            <Label htmlFor="membership-discounted-price">
                                                السعر بعد الخصم (اختياري)
                                            </Label>
                                            <Input
                                                id="membership-discounted-price"
                                                type="number"
                                                min="0"
                                                placeholder="400"
                                                name="discounted_price"
                                                defaultValue={item?.discounted_price!}
                                            />
                                            <InputError message={errors.discounted_price} />
                                        </div>

                                        <div className="grid gap-3">
                                            <Label htmlFor="membership-duration">مدة العضوية (بالأيام)</Label>
                                            <Input
                                                id="membership-duration"
                                                type="number"
                                                min="1"
                                                placeholder="30"
                                                name="duration_days"
                                                defaultValue={item?.duration_days!}
                                            />
                                            <InputError message={errors.duration_days} />
                                        </div>
                                    </>
                                )}

                                {/* حالة العضوية */}
                                {item && !isTranslate && (
                                    <>
                                        <div className="grid gap-3">
                                            <Select
                                                name="is_active"
                                                defaultValue={item.is_active ? "true" : "false"}
                                            >
                                                <SelectTrigger className="w-[180px]">
                                                    <SelectValue placeholder="اختر الحالة" />
                                                </SelectTrigger>
                                                <SelectContent>
                                                    <SelectGroup>
                                                        <SelectLabel>حالة العضوية</SelectLabel>
                                                        <SelectItem value="true">نشط</SelectItem>
                                                        <SelectItem value="false">غير نشط</SelectItem>
                                                    </SelectGroup>
                                                </SelectContent>
                                            </Select>
                                        </div>

                                        <div className="grid gap-3">
                                            <Label htmlFor="membership-sort-order">
                                                ترتيب العضوية (الأقل يظهر أولاً)
                                            </Label>
                                            <Input
                                                id="membership-sort-order"
                                                type="number"
                                                min="0"
                                                placeholder="0"
                                                name="sort_order"
                                                defaultValue={item?.sort_order!}
                                            />
                                            <InputError message={errors.sort_order} />
                                        </div>
                                    </>
                                )}

                                {/* المتطلبات */}
                                <DynamicInputList
                                    label="متطلبات العضوية"
                                    name="requirements"
                                    count={numRequired}
                                    setCount={setNumRequired}
                                    values={translateField(item!, "requirements", isTranslate)}
                                    errors={errors}
                                    isTranslate={isTranslate}
                                />

                                {/* المميزات */}
                                <DynamicInputList
                                    label="مميزات العضوية"
                                    name="features"
                                    count={numFeatures}
                                    setCount={setNumFeatures}
                                    values={translateField(item!, "features", isTranslate)}
                                    errors={errors}
                                    isTranslate={isTranslate}
                                />

                                {/* الوصف */}
                                <div className="grid gap-3">
                                    <Label htmlFor="membership-description">وصف العضوية</Label>
                                    <Textarea
                                        id="membership-description"
                                        rows={4}
                                        maxLength={255}
                                        className="max-h-32"
                                        name="description"
                                        placeholder="اكتب وصفًا مختصرًا للعضوية"
                                        defaultValue={translateField(item!, "description", isTranslate)}
                                    />
                                    <InputError message={errors.description} />
                                </div>
                            </div>

                            <DialogFooter className="mt-2">
                                <DialogClose asChild>
                                    <Button type="reset" variant="outline">
                                        الغاء
                                    </Button>
                                </DialogClose>
                                <Button type="submit" className="cursor-pointer" disabled={processing}>
                                    {processing && <LoaderCircleIcon className="h-4 w-4 animate-spin" />}
                                    {isTranslate
                                        ? `ترجمة العضوية: ${item?.name}`
                                        : item
                                            ? "تحديث العضوية"
                                            : "حفظ العضوية"}
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
