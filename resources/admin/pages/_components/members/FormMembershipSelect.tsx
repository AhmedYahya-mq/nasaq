import InputError from "@/components/input-error";
import { Button } from "@/components/ui/button";
import { Dialog, DialogClose, DialogContent, DialogFooter, DialogHeader, DialogTrigger } from "@/components/ui/dialog";
import { Label } from "@/components/ui/label";
import { Select, SelectContent, SelectGroup, SelectItem, SelectLabel, SelectTrigger, SelectValue } from "@/components/ui/select";
import { getErrorMessage } from "@/lib/utils";
import { memberships } from "@/routes/admin";
import { subscribeMembership, upgradeMembership } from "@/routes/admin/members";
import { Members } from "@/types/model/members";
import { Membership } from "@/types/model/membership";
import { Form } from "@inertiajs/react";
import axios from "axios";
import { LoaderCircleIcon } from "lucide-react";
import { useEffect, useState } from "react";
import { toast } from "sonner";

export default function FormMembershipSelect({
    member,
    tigger,
    isUpgrade = false,
}: {
    member: Members;
    tigger: string;
    isUpgrade?: boolean;
}) {
    const [isOpen, setIsOpen] = useState(false);
    const [membership, setMembership] = useState<Membership[]>([]);
    const [upgradeType, setUpgradeType] = useState<string>("upgrade_only");

    const upgradeDescriptions: Record<string, { desc: string, example: string }> = {
        upgrade_only: {
            desc: "ترقية العضوية الجديدة تبدأ من اليوم فقط، لا تأخذ الأيام المتبقية من العضوية القديمة.",
            example: "مثال: إذا كانت العضوية القديمة متبقية 100 يوم، والعضوية الجديدة مدتها 365 يوم، ستصبح العضوية الجديدة تنتهي بعد 365 يوم من اليوم."
        },
        upgrade_extend: {
            desc: "تمديد الأيام المتبقية من العضوية القديمة مع إضافة مدة العضوية الجديدة.",
            example: "مثال: العضوية القديمة متبقية 100 يوم، والعضوية الجديدة 365 يوم. ستصبح مدة العضوية الجديدة 465 يوم (100 + 365)."
        },
        upgrade_with_balance: {
            desc: "تحويل قيمة الأيام المتبقية من العضوية القديمة إلى أيام في العضوية الجديدة، لتقصير أو زيادة المدة حسب الفرق.",
            example: "مثال: العضوية القديمة قيمتها 200 ريال متبقية 100 يوم، العضوية الجديدة قيمتها 300 ريال. سيتم تحويل قيمة الأيام المتبقية (100 × 200 ÷ 365 ≈ 55 ريال) إلى عدد أيام في العضوية الجديدة (55 ÷ (300 ÷ 365) ≈ 67 يوم)."
        },
        upgrade_with_extra_payment: {
            desc: "احتساب الفرق المالي مع العضوية الجديدة ودفع الفرق إذا كان موجودًا، ثم إضافة مدة العضوية بناءً على المبلغ الجديد.",
            example: "مثال: العضوية القديمة قيمتها 200 ريال متبقية 100 يوم، العضوية الجديدة قيمتها 300 ريال. سيتم حساب قيمة الأيام المتبقية ≈55 ريال، مجموع السعر = 300 + 55 = 355 ريال، وستحسب مدة العضوية الجديدة كاملة بناءً على هذا المبلغ."
        }
    };

    const formProps = isUpgrade ? upgradeMembership.form(member.id) : subscribeMembership.form(member.id);

    useEffect(() => {
        axios
            .get(memberships().url)
            .then((res) => setMembership(res.data))
            .catch((err) => toast.error(getErrorMessage(err)));
    }, []);

    return (
        <Dialog open={isOpen} onOpenChange={setIsOpen}>
            <DialogTrigger asChild>
                <Button >
                    {tigger}
                </Button>
            </DialogTrigger>
            <DialogContent className="sm:max-w-lg">
                <DialogHeader>{isUpgrade ? "ترقية العضوية" : "تعيين عضوية جديدة"}</DialogHeader>
                <Form
                    {...formProps}
                    onSuccess={
                        () => {
                            setIsOpen(false);
                            toast.success(isUpgrade ? "تم ترقية العضوية بنجاح" : "تم تعيين العضوية بنجاح");
                        }
                    }
                    onError={() => { toast.error("حدث خطأ أثناء حفظ العضوية. حاول مرة أخرى."); }}
                    resetOnSuccess

                    options={
                        {
                            preserveUrl: true,
                        }
                    }
                >
                    {({ processing, errors }) => (
                        <>
                            {/* اختيار العضوية */}
                            <div className="grid gap-3">
                                <Label htmlFor="membership_id" className="required-label">العضوية</Label>
                                <Select
                                    name="membership_id"
                                    dir="rtl"
                                    defaultValue={member.membership_id?.toString() || "none"}
                                    required>
                                    <SelectTrigger id="membership_id">
                                        <SelectValue placeholder="اختر عضوية..." />
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectGroup>
                                            <SelectLabel>العضويات</SelectLabel>
                                            <SelectItem value="none">بدون عضوية</SelectItem>
                                            {membership?.map((m) => (
                                                <SelectItem key={m.id} value={m.id.toString()}>{m.name}</SelectItem>
                                            ))}
                                        </SelectGroup>
                                    </SelectContent>
                                </Select>
                                <InputError message={errors.membership_id} />
                            </div>

                            {/* اختيار طريقة الترقية */}
                            {isUpgrade && member.membership_expires_at && (
                                <div className="grid gap-1 mt-4">
                                    <Label htmlFor="upgrade_type" className="required-label">طريقة الترقية</Label>
                                    <Select
                                        name="upgrade_type"
                                        dir="rtl"
                                        value={upgradeType}
                                        onValueChange={(val) => setUpgradeType(val)}
                                        required
                                    >
                                        <SelectTrigger id="upgrade_type">
                                            <SelectValue placeholder="اختر طريقة الترقية..." />
                                        </SelectTrigger>
                                        <SelectContent>
                                            <SelectGroup>
                                                <SelectLabel>طرق الترقية</SelectLabel>
                                                <SelectItem value="upgrade_only">بدون اعتبار للقديمة</SelectItem>
                                                <SelectItem value="upgrade_extend">تمديد الوقت المتبقي</SelectItem>
                                                <SelectItem value="upgrade_with_balance">حسب الرصيد</SelectItem>
                                                <SelectItem value="upgrade_with_extra_payment">دفع الفرق</SelectItem>
                                            </SelectGroup>
                                        </SelectContent>
                                    </Select>

                                    {/* شرح منفصل */}
                                    <div className="p-2 mt-1 text-sm text-muted-foreground rounded">
                                        <strong>الوصف:</strong> {upgradeDescriptions[upgradeType].desc}
                                    </div>
                                    <div className="p-2 mt-1 text-sm text-primary bg-card rounded">
                                        <strong>مثال:</strong> {upgradeDescriptions[upgradeType].example}
                                    </div>

                                    <InputError message={errors.upgrade_type} />
                                </div>
                            )}

                            <DialogFooter className="mt-4">
                                <DialogClose asChild>
                                    <Button type="reset" variant="outline">إلغاء</Button>
                                </DialogClose>
                                <Button type="submit" className="cursor-pointer" disabled={processing}>
                                    {processing && <LoaderCircleIcon className="h-4 w-4 animate-spin mr-2" />}
                                    {isUpgrade ? "ترقية العضو" : "حفظ العضو"}
                                </Button>
                            </DialogFooter>
                        </>
                    )}
                </Form>
            </DialogContent>
        </Dialog>
    );
}
