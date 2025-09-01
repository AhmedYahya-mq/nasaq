import HeadingSmall from '@/components/heading-small';
import InputError from '@/components/input-error';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardFooter, CardTitle } from '@/components/ui/card';
import { Dialog, DialogClose, DialogContent, DialogDescription, DialogFooter, DialogTitle, DialogTrigger } from '@/components/ui/dialog';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { destroy, destroyOne } from '@/routes/admin/sessions';
import { type SecurityProps } from '@/types/shared/auth';
import { Form, Link } from '@inertiajs/react';
import { HelpCircleIcon, MonitorIcon, SmartphoneIcon } from 'lucide-react';
import { useRef, useState } from 'react';

export default function SessionsContainer({ sessions }: { sessions: SecurityProps['sessions'] }) {
    const passwordInput = useRef<HTMLInputElement>(null);
    const [open, setOpen] = useState(false);
    return (
        <div className="space-y-6">
            <HeadingSmall title="جلسات المتصفح" description="إدارة وتسجيل الخروج من جلساتك النشطة على المتصفحات والأجهزة الأخرى." />
            <Card className='sm:p-5 p-4'>
                <CardDescription>
                    إذا لزم الأمر، يمكنك تسجيل الخروج من جميع جلسات المتصفح الأخرى على جميع أجهزتك. تجد أدناه بعض جلساتك الأخيرة، ولكن قد لا تكون هذه القائمة شاملة. إذا شعرتَ أن حسابك قد تعرض للاختراق، فعليك أيضًا تحديث كلمة مرورك.
                </CardDescription>
                <CardContent>
                    {sessions && sessions.length > 0 ? (
                        <div className="space-y-3">
                            {sessions.map((session, index) => (
                                <div key={index} className="">
                                    <div className="flex items-center space-x-4">
                                        <div>
                                            {session.agent ? (
                                                session.agent.is_desktop ? (
                                                    <MonitorIcon size={24} />
                                                ) : (
                                                    <SmartphoneIcon size={24} />
                                                )
                                            ) : (
                                                <HelpCircleIcon size={24} />
                                            )}
                                        </div>
                                        <div className="flex-1">
                                            <div className="font-medium text-sm">
                                                {session.agent.platform ? session.agent.platform : 'Unknown'} - {session.agent.browser ? session.agent.browser : 'Unknown'}
                                            </div>
                                            <div className="text-sm text-gray-500">
                                                {session.ip_address}, {session.is_current_device ? (
                                                    <span className="text-green-500 font-semibold">هذا الجهاز</span>
                                                ) : (
                                                    <>آخر نشاط {session.last_active}</>
                                                )}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            ))}
                        </div>
                    ) : (
                        <div className="text-gray-500">لا توجد جلسات نشطة.</div>
                    )}
                </CardContent>
                <CardFooter>
                    <Dialog open={open} onOpenChange={setOpen}>
                        <DialogTrigger asChild>
                            <Button>تسجيل الخروج من جلسات المتصفح الأخرى</Button>
                        </DialogTrigger>
                        <DialogContent>
                            <DialogTitle>تسجيل الخروج من جلسات المتصفح الأخرى</DialogTitle>
                            <DialogDescription>
                                يرجى إدخال كلمة المرور الخاصة بك للتأكيد على رغبتك في تسجيل الخروج من جلسات المتصفح الأخرى عبر جميع أجهزتك.
                            </DialogDescription>

                            <Form
                                {...destroy.form()}
                                options={{
                                    preserveScroll: true,
                                    only: ['sessions'],
                                }}
                                onSuccess={
                                    () => {
                                        setOpen(false);
                                    }
                                }

                                resetOnSuccess
                                disableWhileProcessing
                                className="space-y-6"
                            >
                                {({ resetAndClearErrors, processing, errors }) => (
                                    <>
                                        <div className="grid gap-2">
                                            <Label htmlFor="password" className="sr-only">
                                                كلمة المرور
                                            </Label>

                                            <Input
                                                id="password"
                                                type="password"
                                                name="password"
                                                ref={passwordInput}
                                                placeholder="كلمة المرور"
                                                autoComplete="current-password"
                                            />

                                            <InputError message={errors.password} />
                                        </div>

                                        <DialogFooter className="gap-2">
                                            <DialogClose asChild>
                                                <Button variant="secondary" onClick={() => resetAndClearErrors()}>
                                                    الغاء
                                                </Button>
                                            </DialogClose>

                                            <Button disabled={processing} asChild>
                                                <button type="submit">تسجيل الخروج من جلسات المتصفح الأخرى</button>
                                            </Button>
                                        </DialogFooter>
                                    </>
                                )}
                            </Form>
                        </DialogContent>
                    </Dialog>
                </CardFooter>
            </Card>
        </div>
    );
}
