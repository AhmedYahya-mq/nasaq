import { Download, ArrowLeft, ArrowUpLeftFromSquareIcon, CreditCard, FileText, User2, Receipt, FileImage } from "lucide-react";
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
                <div className="flex flex-col gap-2">
                    <div className="flex flex-wrap items-center justify-between gap-3">
                        <div className="flex flex-wrap items-center gap-3 min-w-0">
                            <div className="flex items-center gap-2 min-w-0">
                                <div className="w-10 h-10 rounded-full bg-primary/10 text-primary flex items-center justify-center font-semibold text-sm">
                                    {application.user?.name?.slice(0, 2) ?? 'NA'}
                                </div>
                                <div className="min-w-0">
                                    <h1 className="text-xl font-semibold text-foreground truncate">
                                        {application.user?.name}
                                    </h1>
                                    <div className="text-sm text-muted-foreground truncate">{application.user?.email}</div>
                                </div>
                            </div>
                            <Link
                                href={show(application.user?.id ?? 0).url}
                                aria-label="تفاصيل المتقدم"
                                className="inline-flex items-center gap-2 text-primary hover:underline"
                            >
                                <ArrowUpLeftFromSquareIcon className="h-4 w-4" />
                                <span className="text-sm font-medium">تفاصيل المتقدم</span>
                            </Link>
                        </div>
                        <Badge
                            style={{ backgroundColor: application.status.color }}
                            className="text-black text-sm px-3 py-1"
                        >
                            {application.status.label_ar}
                        </Badge>
                    </div>

                    <div className="flex flex-wrap items-center gap-4 text-sm text-muted-foreground">
                        <div className="flex items-center gap-2">
                            <span className="font-medium text-foreground">من:</span>
                            <span>{application.user?.name}</span>
                        </div>
                        <div className="flex items-center gap-2">
                            <span className="text-muted-foreground">|</span>
                            <span>{formatDate(application.submitted_at)}</span>
                        </div>
                    </div>
                </div>
            </div>

            {/* Content */}
            <div className="flex-1 scrollbar">
                <div className="p-6">
                    <Card className="p-6 shadow-card">
                        <div className="space-y-6 text-foreground">
                            <div>
                                <h3 className="text-lg font-semibold mb-3">البيانات الشخصية</h3>
                                <div className="grid grid-cols-1 md:grid-cols-2 gap-3">
                                    <div className="bg-muted/40 rounded-md p-3">
                                        <div className="text-xs text-muted-foreground">الاسم الكامل</div>
                                        <div className="font-medium">{application.user?.name || 'غير متوفر'}</div>
                                    </div>
                                    <div className="bg-muted/40 rounded-md p-3">
                                        <div className="text-xs text-muted-foreground">البريد الإلكتروني</div>
                                        <div className="font-medium">{application.user?.email || 'غير متوفر'}</div>
                                    </div>
                                    <div className="bg-muted/40 rounded-md p-3">
                                        <div className="text-xs text-muted-foreground">رقم الهاتف</div>
                                        <div className="font-medium">{application.user?.phone || 'غير متوفر'}</div>
                                    </div>
                                    <div className="bg-muted/40 rounded-md p-3">
                                        <div className="text-xs text-muted-foreground">المسمى الوظيفي</div>
                                        <div className="font-medium">{application.user?.job_title || 'غير متوفر'}</div>
                                    </div>
                                    <div className="bg-muted/40 rounded-md p-3">
                                        <div className="text-xs text-muted-foreground">العنوان</div>
                                        <div className="font-medium">{application.user?.address || 'غير متوفر'}</div>
                                    </div>
                                    <div className="bg-muted/40 rounded-md p-3">
                                        <div className="text-xs text-muted-foreground">السيرة الذاتية</div>
                                        <div className="font-medium">{application.user?.bio || 'غير متوفر'}</div>
                                    </div>
                                    <div className="bg-muted/40 rounded-md p-3 md:col-span-2">
                                        <div className="text-xs text-muted-foreground">تاريخ الميلاد</div>
                                        <div className="font-medium">{application.user?.birthday || 'غير متوفر'}</div>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <h3 className="text-lg font-semibold mb-3">بيانات الطلب</h3>
                                <div className="grid grid-cols-1 md:grid-cols-2 gap-3">
                                    <div className="bg-muted/40 rounded-md p-3">
                                        <div className="text-xs text-muted-foreground">نوع العضوية المطلوبة</div>
                                        <div className="font-medium">{application.membership_type || 'غير متوفر'}</div>
                                    </div>
                                    <div className="bg-muted/40 rounded-md p-3">
                                        <div className="text-xs text-muted-foreground">رقم الهوية الوطنية</div>
                                        <div className="font-medium">{application.national_id || 'غير متوفر'}</div>
                                    </div>
                                    <div className="bg-muted/40 rounded-md p-3">
                                        <div className="text-xs text-muted-foreground">الحالة الوظيفية</div>
                                        <div className="font-medium">{application.employment_status?.label_ar || 'غير متوفر'}</div>
                                    </div>
                                    <div className="bg-muted/40 rounded-md p-3">
                                        <div className="text-xs text-muted-foreground">جهة العمل الحالية</div>
                                        <div className="font-medium">{application.current_employer || 'غير متوفر'}</div>
                                    </div>
                                    <div className="bg-muted/40 rounded-md p-3 md:col-span-2">
                                        <div className="text-xs text-muted-foreground">رقم هيئة التخصصات الصحية</div>
                                        <div className="font-medium">{application.scfhs_number || 'غير متوفر'}</div>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <h3 className="text-lg font-semibold mb-3">حالة الطلب</h3>
                                <div className="grid grid-cols-1 md:grid-cols-2 gap-3">
                                    <div className="bg-muted/40 rounded-md p-3">
                                        <div className="text-xs text-muted-foreground">الحالة</div>
                                        <div className="font-medium">{application.status?.label_ar || ''}</div>
                                    </div>
                                    {application.admin_notes && (
                                        <div className="bg-muted/40 rounded-md p-3 md:col-span-2">
                                            <div className="text-xs text-muted-foreground">ملاحظات الإدارة</div>
                                            <div className="font-medium">{application.admin_notes}</div>
                                        </div>
                                    )}
                                    {application.submitted_at && (
                                        <div className="bg-muted/40 rounded-md p-3">
                                            <div className="text-xs text-muted-foreground">تاريخ التقديم</div>
                                            <div className="font-medium">{formatFullDate(application.submitted_at)}</div>
                                        </div>
                                    )}
                                    {application.reviewed_at && (
                                        <div className="bg-muted/40 rounded-md p-3">
                                            <div className="text-xs text-muted-foreground">تاريخ المراجعة</div>
                                            <div className="font-medium">{formatFullDate(application.reviewed_at)}</div>
                                        </div>
                                    )}
                                    {application.approved_at && (
                                        <div className="bg-muted/40 rounded-md p-3">
                                            <div className="text-xs text-muted-foreground">تاريخ الموافقة</div>
                                            <div className="font-medium">{formatFullDate(application.approved_at)}</div>
                                        </div>
                                    )}
                                    {application.rejected_at && (
                                        <div className="bg-muted/40 rounded-md p-3">
                                            <div className="text-xs text-muted-foreground">تاريخ الرفض</div>
                                            <div className="font-medium">{formatFullDate(application.rejected_at)}</div>
                                        </div>
                                    )}
                                </div>
                            </div>
                        </div>
                    </Card>


                    {/* Payment Details */}
                    {application.payment && (
                        <Card className="mt-4 p-6 shadow-card">
                            <div className="flex items-center justify-between mb-4">
                                <h3 className="text-lg font-semibold flex items-center gap-2">
                                    <CreditCard className="h-5 w-5 text-muted-foreground" />
                                    بيانات الدفع
                                </h3>
                                {application.payment.status && (
                                    <Badge
                                        style={{ backgroundColor: application.payment.status.color || undefined }}
                                        className="text-white"
                                    >
                                        {application.payment.status.label ?? ''}
                                    </Badge>
                                )}
                            </div>

                            {/* Total amount */}
                            <div className="bg-muted/40 rounded-md p-4 flex items-center justify-between">
                                <div className="text-sm text-muted-foreground">المبلغ الإجمالي</div>
                                <div className="text-xl font-bold">
                                    {application.payment.amount ?? 0}
                                    <span className="text-sm font-medium ml-2">{application.payment.currency ?? ''}</span>
                                </div>
                            </div>

                            {/* Invoice meta */}
                            <div className="grid grid-cols-1 md:grid-cols-2 gap-3 mt-4">
                                {application.payment.invoice_id && (
                                    <div className="bg-muted/30 rounded-md p-3 flex items-center gap-2">
                                        <Receipt className="h-4 w-4 text-muted-foreground" />
                                        <div>
                                            <div className="text-xs text-muted-foreground">رقم الفاتورة</div>
                                            <div className="font-medium">{application.payment.invoice_id}</div>
                                        </div>
                                    </div>
                                )}
                                {application.payment.created_at && (
                                    <div className="bg-muted/30 rounded-md p-3">
                                        <div className="text-xs text-muted-foreground">تاريخ الدفع</div>
                                        <div className="font-medium">{formatFullDate(application.payment.created_at)}</div>
                                    </div>
                                )}
                            </div>

                            {/* Discounts */}
                            <h4 className="text-md font-semibold mt-6 mb-3">تفاصيل الخصومات</h4>
                            <div className="grid grid-cols-1 md:grid-cols-2 gap-3">
                                {application.payment.original_price !== undefined && (
                                    <div className="bg-muted/30 rounded-md p-3">
                                        <div className="text-xs text-muted-foreground">السعر الأصلي</div>
                                        <div className="font-medium">{application.payment.original_price}</div>
                                    </div>
                                )}
                                {application.payment.discount !== undefined && (
                                    <div className="bg-muted/30 rounded-md p-3">
                                        <div className="text-xs text-muted-foreground">إجمالي الخصم</div>
                                        <div className="font-medium">{application.payment.discount}</div>
                                    </div>
                                )}
                                {application.payment.membership_discount !== undefined && (
                                    <div className="bg-muted/30 rounded-md p-3">
                                        <div className="text-xs text-muted-foreground">خصم العضوية</div>
                                        <div className="font-medium">{application.payment.membership_discount}</div>
                                    </div>
                                )}
                                {application.payment.coupon_discount !== undefined && (
                                    <div className="bg-muted/30 rounded-md p-3">
                                        <div className="text-xs text-muted-foreground">خصم الكوبون</div>
                                        <div className="font-medium">
                                            {application.payment.coupon_discount}
                                            {application.payment.coupon_code && (
                                                <span className="ml-2 text-muted-foreground">({application.payment.coupon_code})</span>
                                            )}
                                        </div>
                                    </div>
                                )}
                            </div>
                        </Card>
                    )}


                    {/* Attachments */}
                    {application.files && application.files.length > 0 && (
                        <Card className="mt-4 p-4 shadow-card">
                            <h3 className="font-medium text-foreground mb-3">المرفقات ({application.files.length})</h3>
                            <div className="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
                                {application.files.map((attachment, index) => {
                                    const fileName = attachment.file_name || '';
                                    const extMatch = fileName.match(/\.([a-z0-9]+)$/i);
                                    const ext = extMatch ? extMatch[1].toLowerCase() : '';
                                    const isImage = (attachment.file_type && attachment.file_type.startsWith('image/'))
                                        || /(jpg|jpeg|png|gif|webp|svg)$/i.test(ext);
                                    const isPdf = (attachment.file_type === 'application/pdf') || ext === 'pdf';

                                    return (
                                        <div key={index} className="rounded-md border border-border overflow-hidden bg-card">
                                            {isImage ? (
                                                <div className="group">
                                                    <img
                                                        src={attachment.url}
                                                        alt={attachment.file_name}
                                                        className="h-32 w-full object-cover cursor-pointer"
                                                        onClick={() => window.open(attachment.url, '_blank')}
                                                    />
                                                    <div className="flex items-center justify-between p-2">
                                                        <span className="text-xs text-foreground line-clamp-1">{attachment.file_name}</span>
                                                        <Button variant="ghost" size="icon" onClick={() => window.open(attachment.url, '_blank')}>
                                                            <Download className="h-4 w-4" />
                                                        </Button>
                                                    </div>
                                                </div>
                                            ) : isPdf ? (
                                                <div>
                                                    <div className="h-32 w-full bg-muted/40">
                                                        <object data={attachment.url} type="application/pdf" className="w-full h-full">
                                                            <div className="w-full h-full flex items-center justify-center text-xs text-muted-foreground">
                                                                لا يمكن عرض المعاينة
                                                            </div>
                                                        </object>
                                                    </div>
                                                    <div className="flex items-center justify-between p-2">
                                                        <span className="text-xs text-foreground line-clamp-1">{attachment.file_name}</span>
                                                        <div className="flex items-center gap-1">
                                                            <Button variant="ghost" size="sm" onClick={() => window.open(attachment.url, '_blank')}>فتح</Button>
                                                            <Button variant="ghost" size="icon" onClick={() => window.open(attachment.url, '_blank')}>
                                                                <Download className="h-4 w-4" />
                                                            </Button>
                                                        </div>
                                                    </div>
                                                </div>
                                            ) : (
                                                <div className="flex items-center justify-between p-3">
                                                    <div className="flex items-center gap-2">
                                                        <FileText className="h-4 w-4 text-muted-foreground" />
                                                        <span className="text-sm text-foreground line-clamp-1">{attachment.file_name}</span>
                                                        {ext && (
                                                            <span className="text-[10px] px-1.5 py-0.5 rounded bg-muted text-muted-foreground">{ext.toUpperCase()}</span>
                                                        )}
                                                    </div>
                                                    <Button variant="ghost" size="icon" onClick={() => window.open(attachment.url, '_blank')}>
                                                        <Download className="h-4 w-4" />
                                                    </Button>
                                                </div>
                                            )}
                                        </div>
                                    );
                                })}
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
