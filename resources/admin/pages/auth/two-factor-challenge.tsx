// Components

import { Form, Head } from '@inertiajs/react';
import { LoaderCircle } from 'lucide-react';

import InputError from '@/components/input-error';
import TextLink from '@/components/text-link';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AuthLayout from '@/layouts/auth-layout';
import { useState } from 'react';
import { store } from '@/routes/admin/two-factor/login';

export default function TowFactorChallenge() {
    const [isCodeSent, setIsCodeSent] = useState(true);

    return (
        <AuthLayout
            title={
                isCodeSent ? 'رمز المصادقة الثنائية' : 'رمز الاسترجاع'
            }
            description={
                isCodeSent ? "أدخل الرمز المكوَّن من 6 أرقام الذي يولده تطبيق المصادقة على هاتفك لتأكيد تسجيل الدخول." : 'يرجى تأكيد الوصول إلى حسابك عن طريق إدخال أحد رموز الاسترداد في حالات الطوارئ.'
            }
        >
            <Head title="المصادقة الثنائية" />

            <div className="space-y-6">
                <Form {...store.form()}
                >
                    {({ processing, errors }) => (
                        <>
                            {
                                isCodeSent ? (
                                    <div className="grid gap-2">
                                        <Label htmlFor="code">الرمز</Label>
                                        <Input key="code" id="code" type="text" name="code" autoComplete="off" autoFocus placeholder="XXX-XXX" onInput={
                                            (e: React.FormEvent<HTMLInputElement>) => {
                                                e.currentTarget.value = e.currentTarget.value.replace(/[^\d]/g, '').replace(/(.{3})/, '$1-').slice(0, 7);
                                            }
                                        } />
                                        <InputError message={errors.code} />
                                    </div>
                                ) : (
                                    <div className="grid gap-2">
                                        <Label htmlFor="recovery_code">رمز الاسترجاع</Label>
                                        <Input key="recovery_code" id="recovery_code" type="text" name="recovery_code" autoComplete="off" autoFocus placeholder="hs4nx2SU7j-hQQD8VucuN"
                                            onInput={
                                                (e: React.FormEvent<HTMLInputElement>) => {
                                                    const input = e.currentTarget;
                                                    let value = input.value.replace(/[^a-zA-Z0-9]/g, '');
                                                    if (value.length > 10) {
                                                        value = value.slice(0, 10) + '-' + value.slice(10, 20);
                                                    }
                                                    input.value = value.slice(0, 21);
                                                }
                                            }
                                        />
                                        <InputError message={errors.recovery_code} />
                                    </div>
                                )
                            }
                            <div className="my-6 flex items-center justify-start">
                                <Button className="w-full" disabled={processing}>
                                    {processing && <LoaderCircle className="h-4 w-4 animate-spin" />}
                                    تأكيد
                                </Button>
                            </div>
                        </>
                    )}
                </Form>

                <div className="space-x-1 text-center text-sm text-muted-foreground">
                    <TextLink href="#" onClick={(e) => {
                        e.preventDefault();
                        setIsCodeSent(!isCodeSent);
                    }}>
                        {
                            isCodeSent ? 'استخدم رمز استرجاع بدلاً من ذلك' : 'استخدم رمز المصادقة الثنائية بدلاً من ذلك'
                        }
                    </TextLink>
                </div>
            </div>
        </AuthLayout>
    );
}
