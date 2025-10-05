import { Download, FileIcon, FileImageIcon } from "lucide-react"

import { Button } from "@/components/ui/button"
import {
    Card,
    CardContent,
    CardDescription,
    CardFooter,
    CardHeader,
    CardTitle,
} from "@/components/ui/card"
import { Input } from "@/components/ui/input"
import { Label } from "@/components/ui/label"
import {
    Tabs,
    TabsContent,
    TabsList,
    TabsTrigger,
} from "@/components/ui/tabs"
import { Members } from "@/types/model/members"
import { Avatar, AvatarFallback, AvatarImage } from "@/components/ui/avatar"
import { arabicPluralize, formatFullDate } from "@/lib/utils"
import SectionListMemberships from "../membershipApplication/SectionListMembershipApplications"
import { Badge } from "@/components/ui/badge"
import FormMembershipSelect from "./FormMembershipSelect"
import { confirmAlertDialog } from "@/components/custom/ConfirmDialog"
import { router } from "@inertiajs/react"
import { renewMembership } from "@/routes/admin/members"
import { toast } from "sonner"

export default function DetailsMember({ member }: { member: Members }) {
    return (
        <div >
            <Tabs defaultValue="account" className="rtl:rtl" >
                <TabsList className="">
                    <TabsTrigger value="account">معلومات شخصيه</TabsTrigger>
                    <TabsTrigger value="requests">الطلبات الانظمام</TabsTrigger>
                </TabsList>
                <Account member={member} />
                <Requests member={member} />
            </Tabs>
        </div>
    )
}

function Account({ member }: { member: Members }) {
    const renewMembershipA = async () => {
        const ok = await confirmAlertDialog({
            title: 'تأكيد تجديد العضوية',
            description: `تحذير: عند تجديد عضوية ${member.name}، سيتم إضافة 365 يومًا إلى العضوية الحالية (${member.remaining_days!} يومًا)، لتصبح المدة الإجمالية ${member.remaining_days! + 365} يومًا. هل ترغب بالاستمرار؟`,
        });
        if (!ok) return;
        const toastId = toast.loading('جاري تجديد العضوية...');
        router.post(renewMembership(member.id).url, {},
            {
                preserveScroll: true,
                preserveState: true,
                only: ['member'],
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
                preserveUrl: true,
                showProgress: false,
                onSuccess: (res) => {
                    toast.success('تم تجديد العضوية بنجاح', { id: toastId });
                },
                onError: (err) => {
                    toast.error(err.message || 'حدث خطأ أثناء تجديد العضوية', { id: toastId });
                },
                onFinish: () => {
                    toast.dismiss(toastId);
                }
            });
    }
    return (
        <TabsContent value="account">
            <Card>
                <CardHeader className="items-center space-y-1 text-center">
                    <Avatar className="size-28 border-4 border-primary">
                        <AvatarImage src={member.profile_photo_url} />
                        <AvatarFallback>{member.name}</AvatarFallback>
                    </Avatar>
                    <CardTitle>{member.name}</CardTitle>
                    <CardDescription className="text-center">
                        <div>
                            {member.membership_name ?? 'عضو عادي'}
                            {/* اذا كان لديه عضوية يظهر حالته */}
                            {member.membership_id && (
                                <Badge style={{ backgroundColor: member.membership_status?.color }} className="text-white ms-1.5">
                                    {member.membership_status?.label_ar}
                                </Badge>
                            )}
                        </div>
                        {/* اذا في عضوية اريد يظهر تاريخ الانظمام وتاريخ نتهاء العضوية */}
                        {member.membership_id && (
                            <div className="space-y-0.5 text-center">
                                <div>
                                    الايام المتبقية: {arabicPluralize(member.remaining_days!, {
                                        dual: 'يومان',
                                        plural: `${member.remaining_days} أيام`,
                                        singular: member.remaining_days === 0 ? 'انتهت' : 'يوم',
                                    }) ?? 'غير معروف'}
                                </div>
                                <div>
                                    انضم في: {member.membership_started_at ? formatFullDate(member.membership_started_at, false) : 'غير معروف'}
                                </div>
                                <div>
                                    تنتهي عضويته في: {member.membership_expires_at ? formatFullDate(member.membership_expires_at, false) : 'غير معروف'}
                                </div>
                            </div>
                        )}
                    </CardDescription>
                    <CardFooter className="flex flex-col sm:flex-row sm:justify-center gap-2">
                        {member.membership_id ? (
                            <>
                                <FormMembershipSelect member={member} tigger="تغيير العضوية" isUpgrade={true} />
                                <Button variant="secondary" className="w-full sm:w-auto" onClick={renewMembershipA}>تجديد</Button>
                            </>
                        ) : (
                            <FormMembershipSelect member={member} tigger="تعيين عضوية" />
                        )}
                    </CardFooter>
                </CardHeader>
                <CardContent className="@container grid gap-6">
                    <div className="grid gap-3">
                        <Label htmlFor="tabs-demo-name">البريد الألكتروني</Label>
                        <div>
                            <Input readOnly id="tabs-demo-name" defaultValue={member.email} />
                            {member.email_verified_at === null && (
                                <p className="text-sm text-red-500">
                                    لم يقم العضو {member.name} بتفعيل بريده الألكتروني بعد
                                </p>
                            )}
                        </div>
                    </div>
                    <div className="grid @md:grid-cols-2 gap-3">
                        <div className="grid gap-3">
                            <Label htmlFor="tabs-demo-name">الأسم</Label>
                            <Input readOnly id="tabs-demo-name" defaultValue={member.name} />
                        </div>
                        <div className="grid gap-3">
                            <Label htmlFor="tabs-demo-username">رقم الهاتف</Label>
                            <Input id="tabs-demo-username" readOnly className="ltr text-end" defaultValue={member.phone} />
                        </div>
                    </div>
                    <div className="grid @md:grid-cols-2 gap-3">
                        <div className="grid gap-3">
                            <Label htmlFor="tabs-demo-name">العنوان</Label>
                            <Input readOnly id="tabs-demo-name" defaultValue={member.address} />
                        </div>
                        <div className="grid gap-3">
                            <Label htmlFor="tabs-demo-username">تاريخ الميلاد</Label>
                            <Input id="tabs-demo-username" readOnly className="ltr text-end" defaultValue={formatFullDate(member.birthday, false)} />
                        </div>
                    </div>
                    <div className="grid @md:grid-cols-2 gap-3">
                        <div className="grid gap-3">
                            <Label htmlFor="tabs-demo-name">رقم البطاقة الشخصية</Label>
                            <Input readOnly id="tabs-demo-name" defaultValue={member.membership_Application?.national_id ?? 'لايوجد رقم هوية'} />
                        </div>
                        <div className="grid gap-3">
                            <Label htmlFor="tabs-demo-username">رقم هيئة التخصصات الصحية</Label>
                            <Input id="tabs-demo-username" readOnly className="ltr text-end" defaultValue={member.membership_Application?.scfhs_number ?? 'لايوجد رقم هيئة'} />
                        </div>
                    </div>
                    <div className="grid @md:grid-cols-2 @xl:grid-cols-3 gap-3">
                        <div className="grid gap-3">
                            <Label htmlFor="tabs-demo-name">الحالة الوظيفية </Label>
                            <Input readOnly id="tabs-demo-name" defaultValue={member.employment_status?.label_ar ?? 'لا يوجد'} />
                        </div>
                        <div className="grid gap-3">
                            <Label htmlFor="tabs-demo-username">المسمى الوظيفي</Label>
                            <Input id="tabs-demo-username" readOnly className="ltr text-end" defaultValue={member.job_title ?? 'لا يوجد'} />
                        </div>
                        <div className="grid gap-3 @xl:col-span-1 @md:col-span-2">
                            <Label htmlFor="tabs-demo-username">جهة العمل الحالية</Label>
                            <Input id="tabs-demo-username" readOnly className="ltr text-end" defaultValue={member.membership_Application?.current_employer ?? 'لا يوجد'} />
                        </div>
                    </div>
                    <div className="grid gap-3">
                        <Label htmlFor="tabs-demo-username">نبذة عن العضو</Label>
                        <div className="mt-1">
                            <p className="whitespace-pre-wrap text-muted-foreground">
                                {member.bio ?? 'لا يوجد نبذة'}
                            </p>
                        </div>
                    </div>
                    {/* Attachments */}
                    {member.membership_Application?.files && member.membership_Applications_count! > 0 && (
                        <Card className="mt-4 p-4 shadow-card">
                            <h3 className="font-medium text-foreground mb-3">الملفات ({member.membership_Application?.files.length})</h3>
                            <div className="space-y-2">
                                {member.membership_Application?.files.map((attachment, index) => (
                                    <div key={index} className="flex items-center justify-between p-2 bg-muted/50 rounded-md">
                                        <div className="flex items-center gap-2">
                                            {attachment.file_type.startsWith('image/') ? (
                                                <FileImageIcon className="h-5 w-5 text-muted-foreground" />
                                            ) : (
                                                <FileIcon className="h-5 w-5 text-muted-foreground" />
                                            )}
                                            <div className="flex flex-col">
                                                <span className="font-medium">{attachment.file_name}</span>
                                            </div>
                                        </div>
                                        <Button variant="ghost" size="icon" onClick={() => window.open(attachment.url, '_blank')} className="gap-2">
                                            <Download className="h-4 w-4" />
                                        </Button>
                                    </div>
                                ))}
                            </div>
                        </Card>
                    )}


                </CardContent>
            </Card>
        </TabsContent>
    );
}

function Requests({ member }: { member: Members }) {
    return (
        <TabsContent value="requests">
            <Card>
                <CardHeader>
                    <CardTitle>طلبات العضوية</CardTitle>
                    <CardDescription>
                        تم استلام {arabicPluralize(member.membership_Applications_count!, {
                            dual: 'طلبين',
                            plural: `طلبات`,
                            singular: 'طلب واحد',
                        })} من العضو
                        {` ${member.name} `}
                        حتى الآن.
                    </CardDescription>
                </CardHeader>
                <CardContent className="grid gap-6">
                    <SectionListMemberships alawysMobile={true} member_id={member.id} />
                </CardContent>
            </Card>
        </TabsContent>
    );
}
