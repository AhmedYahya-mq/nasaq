import InputError from "@/components/input-error"
import { Button } from "@/components/ui/button"
import {
    Dialog,
    DialogClose,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from "@/components/ui/dialog"
import { Label } from "@/components/ui/label"
import { Textarea } from "@/components/ui/textarea"
import { reject } from "@/routes/admin/membershipApplications"
import { MembershipApplication } from "@/types/model/membershipApplication"
import { Form } from "@inertiajs/react"
import { LoaderCircleIcon } from "lucide-react"
import { useState } from "react"
import { toast } from "sonner"

export default function RejectForm({ applicationId, setApplication }: { applicationId?: string | number, setApplication?: (application: MembershipApplication) => void }) {
    if (!applicationId) return null;
    const [isOpen, setIsOpen] = useState(false);
    return (
        <Dialog open={isOpen} onOpenChange={setIsOpen}>
            <DialogTrigger asChild>
                <Button variant="destructive" type="button">
                    رفض الطلب
                </Button>
            </DialogTrigger>
            <DialogContent className="sm:max-w-[425px]">
                <DialogHeader>
                    <DialogTitle>
                        رفض طلب العضوية
                    </DialogTitle>
                    <DialogDescription>
                        يرجى كتابة سبب الرفض أدناه:
                    </DialogDescription>
                </DialogHeader>
                <Form
                    {...reject.form(applicationId)}
                    onSuccess={(res) => {
                        if (setApplication) {
                            setApplication(res.props.application as MembershipApplication);
                        }
                        setIsOpen(false);
                        toast.success('تم رفض الطلب بنجاح');
                    }}
                    resetOnSuccess={true}
                >
                    {
                        ({ processing, errors }) => (
                            <>
                                <div className="grid gap-4">
                                    <div className="grid gap-3">
                                        <Label htmlFor="note-1">الملاحظة</Label>
                                        <Textarea id="note-1" name="note" maxLength={255} className="max-h-72" required placeholder="أكتب سبب الرفض" />
                                        <InputError message={errors.note} className="mt-2" />
                                    </div>
                                </div>
                                <DialogFooter className="mt-4">
                                    <DialogClose asChild>
                                        <Button variant="outline" disabled={processing}>الغاء</Button>
                                    </DialogClose>
                                    <Button type="submit" disabled={processing} >
                                        {processing && <LoaderCircleIcon className="h-4 w-4 animate-spin" />}
                                        إرسال الرفض
                                    </Button>
                                </DialogFooter>
                            </>
                        )
                    }
                </Form>
            </DialogContent>
        </Dialog>
    )
}
