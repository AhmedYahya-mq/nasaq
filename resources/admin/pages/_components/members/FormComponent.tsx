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
import { format } from "date-fns";
import { Calendar } from "@/components/ui/calendar";
import { store, update } from "@/routes/admin/members";
import { Members } from "@/types/model/members";
import { RadioGroup, RadioGroupItem } from "@/components/ui/radio-group";


function FormComponent({ tableHook }: { tableHook: any }) {
    const { item, isOpen, setOpen } = useContext(OpenFormContext);
    const formRef = useRef<any>(null);
    const { addRow, updateRow } = tableHook;
    const [date, setDate] = useState<Date | undefined>(item?.birthday ? new Date(item.birthday) : undefined);
    const [gender, setGender] = useState<string>(item?.gender ?? 'male');


    // إعادة ضبط التاريخ والجنس عند تغيير العنصر
    useEffect(() => {
        setDate(item?.birthday ? new Date(item.birthday) : undefined);
        setGender(item?.gender ?? 'male');
    }, [item]);

    const formProps = item ? update.form(item.id) : store.form();

    const resetAndClose = (page?: any) => {
        formRef.current?.reset();
        if (page?.props?.member) {
            const member = page.props.member as Members;
            item ? updateRow(member) : addRow(member);
        }
        setOpen?.(false);
    };

    // دالة مساعدة لحقول الإدخال
    const renderInput = (id: string, name: string, label: string, value?: string, type = "text", required = false) => (
        <div className="grid gap-3">
            <Label htmlFor={id} className={required ? "required-label" : ""}>{label}</Label>
            {type === "tel" ? (
                <PhoneInput id={id} name={name} defaultValue={value} required={required} />
            ) : type === "password" ? (
                <InputPassword id={id} name={name} />
            ) : (
                <Input id={id} name={name} type={type} defaultValue={value} required={required} />
            )}
            <InputError message={(formRef.current?.errors || {})[name]} />
        </div>
    );

    return (
        <Dialog open={isOpen} onOpenChange={(open) => !open && resetAndClose()}>
            <DialogContent className="sm:max-w-[425px]">
                <DialogHeader className="mb-4">
                    <DialogTitle>{item ? `تعديل عضو: ${item.name}` : "إضافة عضو جديدة"}</DialogTitle>
                    <DialogDescription>{item ? `قم بتحديث بيانات عضو "${item.name}" بعناية.` : "أضف عضو جديد بسهولة وسرعة."}</DialogDescription>
                </DialogHeader>

                <Form
                    ref={formRef}
                    {...formProps}
                    disableWhileProcessing
                    onSuccess={resetAndClose}
                    options={{ preserveScroll: true, preserveState: true, preserveUrl: true, replace: false }}
                    onError={(errors) => Object.entries(errors).forEach(([field, message]) => toast.error(`${field}: ${message}`))}
                    className="max-w-2xl"
                >
                    {({ processing, errors }) => (
                        <>
                            <div className="grid gap-4 scrollbar !overflow-hidden hover:!overflow-y-auto max-h-[calc(100vh-230px)] p-1">
                                {renderInput("name-1", "name", "أسم العضو", item?.name, "text", true)}
                                {renderInput("phone-1", "phone", "رقم الهاتف", item?.phone, "tel", true)}
                                {renderInput("email-1", "email", "البريد الإلكتروني", item?.email, "email", true)}
                                {renderInput("address-1", "address", "العنوان", item?.address)}
                                {renderInput("job_title-1", "job_title", "المسمى الوظيفي", item?.job_title)}
                                <div className="grid gap-3">
                                    <Label className="required-label">الجنس</Label>
                                    <RadioGroup defaultValue={gender} onValueChange={setGender} className="flex flex-col gap-4 w-full rtl">
                                        <div className="flex items-center gap-6">
                                            <div className="flex items-center gap-3">
                                                <RadioGroupItem value="male" id="gender-male" />
                                                <Label htmlFor="gender-male">ذكر</Label>
                                            </div>
                                            <div className="flex items-center gap-3">
                                                <RadioGroupItem value="female" id="gender-female" />
                                                <Label htmlFor="gender-female">أنثى</Label>
                                            </div>
                                        </div>
                                    </RadioGroup>
                                    <input type="hidden" name="gender" value={gender} />
                                    <InputError message={errors.gender} />
                                </div>
                                <div className="grid gap-3">
                                    <Label htmlFor="employment_status-1" className="required-label">الحالة الوظيفية</Label>
                                    <Select name="employment_status" dir="rtl" defaultValue={item?.employment_status.value} required>
                                        <SelectTrigger id="employment_status-1">
                                            <SelectValue placeholder="اختر الحالة الوظيفية..." />
                                        </SelectTrigger>
                                        <SelectContent>
                                            <SelectGroup>
                                                <SelectLabel>الحالة الوظيفية</SelectLabel>
                                                <SelectItem value="unemployed">بدون عمل</SelectItem>
                                                <SelectItem value="employed">موظف</SelectItem>
                                                <SelectItem value="entrepreneur">
                                                    صاحب عمل
                                                </SelectItem>
                                                <SelectItem value="academic">
                                                    أكاديمي
                                                </SelectItem>
                                                <SelectItem value="student">
                                                    طالب
                                                </SelectItem>
                                                <SelectItem value="graduate">
                                                    خريج
                                                </SelectItem>
                                            </SelectGroup>
                                        </SelectContent>
                                    </Select>
                                    <InputError message={errors.employment_status} />
                                </div>
                                {/* تاريخ الميلاد */}
                                <div className="grid gap-3">
                                    <Label htmlFor="birthday-1">تاريخ الميلاد</Label>
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
                                            <Calendar mode="single" selected={date} onSelect={setDate} captionLayout="dropdown" />
                                        </PopoverContent>
                                    </Popover>
                                    <InputError message={errors.birthday} />
                                </div>
                                {renderInput("password-1", "password", "كلمة المرور", undefined, "password")}
                                {renderInput("password_confirmation-1", "password_confirmation", "تأكيد كلمة المرور", undefined, "password")}
                            </div>

                            <DialogFooter className="mt-2">
                                <DialogClose asChild>
                                    <Button type="reset" variant="outline">إلغاء</Button>
                                </DialogClose>
                                <Button type="submit" className="cursor-pointer" disabled={processing}>
                                    {processing && <LoaderCircleIcon className="h-4 w-4 animate-spin mr-2" />}
                                    {item ? "تحديث العضو" : "حفظ العضو"}
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
