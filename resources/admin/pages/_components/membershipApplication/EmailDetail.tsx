import { Download, ArrowLeft, ArrowUpLeftFromSquareIcon } from "lucide-react";
import { Button } from "@/components/ui/button";
import { Card } from "@/components/ui/card";
import { Badge } from "@/components/ui/badge";

import { MembershipApplication } from "@/types/model/membershipApplication";
import { Form, Link } from "@inertiajs/react";
import { approve, reject } from "@/routes/admin/membershipApplications";
import RejectForm from "./RejectForm";
import { useState } from "react";
import { toast } from "sonner";
import { formatDate, formatFullDate } from "@/lib/utils";
import { show } from "@/routes/admin/members";

interface EmailDetailProps {
    application: MembershipApplication | null;
    onBack?: () => void;
    onApplicationSelect: (application: MembershipApplication) => void;
}

export function EmailDetail({ application, onBack, onApplicationSelect }: EmailDetailProps) {

    if (!application) {
        return EmailEmpty(onBack);
    }
    return (
        <div className="flex-1 flex flex-col bg-background relative">
            {/* زر رجوع أعلى الصفحة على الشاشات الصغيرة فقط */}
            {onBack && (
                <div className="p-4 border-b border-border bg-card flex items-center">
                    <button
                        className="flex items-center gap-2 text-muted-foreground hover:text-foreground transition"
                        onClick={onBack}
                    >
                        <ArrowLeft className="h-5 w-5" />
                        <span>الرجوع</span>
                    </button>
                </div>
            )}
            {/* Header */}
            <div className={`p-6 border-b border-border bg-card ${onBack ? "pt-2" : ""}`}>
                <div className="flex items-center justify-between mb-4">
                    <div className="flex items-center gap-3">
                        <h1 className="text-xl font-semibold text-foreground">
                            {application.user?.name}
                            <Link href={show(application.user?.id ?? 0).url} type="icon" className="mx-2">
                                <ArrowUpLeftFromSquareIcon className="inline h-4 w-4" />
                            </Link>
                        </h1>
                        <Badge
                            style={{ backgroundColor: application.status.color }}
                            className="text-black"
                        >
                            {application.status.label_ar}
                        </Badge>
                    </div>
                </div>

                {/* Email Meta */}
                <div className="space-y-2 text-sm">
                    <div className="flex items-center justify-between">
                        <div className="flex items-center gap-2">
                            <span className="font-medium text-foreground">From:</span>
                            <span className="text-muted-foreground ">
                                {application.user?.name}
                            </span>
                        </div>
                        <span className="text-muted-foreground">{formatDate(application.submitted_at)}</span>
                    </div>
                </div>
            </div>

            {/* Content */}
            <div className="flex-1 scrollbar">
                <div className="p-6">
                    <Card className="p-6 shadow-card">
                        <div className="prose prose-sm max-w-none text-foreground">
                            <p><strong>الاسم الكامل:</strong> {application.user?.name || 'غير متوفر'}</p>
                            <p><strong>البريد الإلكتروني:</strong> {application.user?.email || 'غير متوفر'}</p>
                            <p><strong>رقم الهاتف:</strong> {application.user?.phone || 'غير متوفر'}</p>
                            <p><strong>المسمى الوظيفي:</strong> {application.user?.job_title || 'غير متوفر'}</p>
                            <p><strong>العنوان:</strong> {application.user?.address || 'غير متوفر'}</p>
                            <p><strong>السيرة الذاتية:</strong> {application.user?.bio || 'غير متوفر'}</p>
                            <p><strong>تاريخ الميلاد:</strong> {application.user?.birthday || 'غير متوفر'}</p>

                            <h3 className="text-lg font-semibold mt-4 mb-2">بيانات الطلب</h3>
                            <p><strong>نوع العضوية المطلوبة:</strong> {application.membership_type || 'غير متوفر'}</p>
                            <p><strong>رقم الهوية الوطنية:</strong> {application.national_id || 'غير متوفر'}</p>
                            <p><strong>الحالة الوظيفية:</strong> {application.employment_status?.label_ar || 'غير متوفر'}</p>
                            <p><strong>جهة العمل الحالية:</strong> {application.current_employer || 'غير متوفر'}</p>
                            <p><strong>رقم هيئة التخصصات الصحية:</strong> {application.scfhs_number || 'غير متوفر'}</p>

                            <h3 className="text-lg font-semibold mt-4 mb-2">حالة الطلب</h3>
                            <p><strong>الحالة:</strong> {application.status?.label_ar || ''}</p>
                            {application.admin_notes && <p><strong>ملاحظات الإدارة:</strong> {application.admin_notes}</p>}
                            {application.submitted_at && <p><strong>تاريخ التقديم:</strong> {formatFullDate(application.submitted_at)}</p>}
                            {application.reviewed_at && <p><strong>تاريخ المراجعة:</strong> {formatFullDate(application.reviewed_at)}</p>}
                            {application.approved_at && <p><strong>تاريخ الموافقة:</strong> {formatFullDate(application.approved_at)}</p>}
                            {application.rejected_at && <p><strong>تاريخ الرفض:</strong> {formatFullDate(application.rejected_at)}</p>}
                        </div>
                    </Card>


                    {/* Attachments */}
                    {application.files && application.files.length > 0 && (
                        <Card className="mt-4 p-4 shadow-card">
                            <h3 className="font-medium text-foreground mb-3">Attachments ({application.files.length})</h3>
                            <div className="space-y-2">
                                {application.files.map((attachment, index) => (
                                    <div key={index} className="flex items-center justify-between p-2 bg-muted/50 rounded-md">
                                        <span className="text-sm text-foreground">{attachment.file_name}</span>
                                        <Button variant="ghost" size="icon" onClick={() => window.open(attachment.url, '_blank')} className="gap-2">
                                            <Download className="h-4 w-4" />
                                        </Button>
                                    </div>
                                ))}
                            </div>
                        </Card>
                    )}

                    {/* link approve and reject */}
                    <div className="mt-6 flex gap-4">
                        {application.status.value === 'pending' && (
                            <>
                                <Form
                                    {...approve.form(application.uuid)}
                                    onSuccess={(res) => {
                                        if (onApplicationSelect) {
                                            onApplicationSelect(res.props.application as MembershipApplication);
                                        }
                                        toast.success('تمت الموافقة على الطلب بنجاح');
                                    }}
                                >
                                    {({ processing }) => (
                                        <Button type="submit" disabled={processing} className="bg-green-600 hover:bg-green-700 text-white">
                                            {processing ? 'جاري الموافقة...' : 'الموافقة على الطلب'}
                                        </Button>
                                    )}
                                </Form>
                                <RejectForm setApplication={(application) => onApplicationSelect(application as MembershipApplication)} applicationId={application.uuid} />
                            </>
                        )}
                    </div>
                </div>
            </div>
        </div>
    );

}

function EmailEmpty(onBack?: () => void) {
    return <div className="flex-1 flex items-center justify-center bg-muted/10">
        <div className="text-center text-muted-foreground w-full">
            {/* زر رجوع يظهر فقط إذا كان onBack موجود (شاشات صغيرة) */}
            {onBack && (
                <button
                    className="absolute left-4 top-4 flex items-center gap-2 text-muted-foreground hover:text-foreground transition"
                    onClick={onBack}
                >
                    <ArrowLeft className="h-5 w-5" />
                    <span>الرجوع</span>
                </button>
            )}
            <div className="w-16 h-16 mx-auto mb-4 bg-muted rounded-full flex items-center justify-center">
                📧
            </div>
            <h3 className="text-lg font-medium mb-2">لم يتم اختيار طلب</h3>
            <p className="text-sm">اختر طلبًا من القائمة لعرض محتواه</p>
        </div>
    </div>;
}
