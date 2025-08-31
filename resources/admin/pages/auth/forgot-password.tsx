// Components
import { store } from '@/actions/App/Http/Controllers/Auth/PasswordResetLinkController';
import { login } from '@/routes/admin';
import { Form, Head } from '@inertiajs/react';
import { LoaderCircle } from 'lucide-react';

import InputError from '@/components/input-error';
import TextLink from '@/components/text-link';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AuthLayout from '@/layouts/auth-layout';
import { type AuthProps } from '@/types/shared/auth';

export default function ForgotPassword({ status }: AuthProps) {
    return (
        <AuthLayout
            title="نسيت كلمة المرور"
            description="أدخل بريدك الإلكتروني لاستلام رابط إعادة تعيين كلمة المرور"
        >
            <Head title="نسيت كلمة المرور" />

            {status && (
                <div className="mb-4 text-center text-sm font-medium text-green-600">
                    {status}
                </div>
            )}

            <div className="space-y-6">
                <Form {...store.form()}>
                    {({ processing, errors }) => (
                        <>
                            <div className="grid gap-2">
                                <Label htmlFor="email">البريد الإلكتروني</Label>
                                <Input
                                    id="email"
                                    type="email"
                                    name="email"
                                    autoComplete="off"
                                    autoFocus
                                    placeholder="email@example.com"
                                />

                                <InputError message={errors.email} />
                            </div>

                            <div className="my-6 flex items-center justify-start">
                                <Button className="w-full" disabled={processing}>
                                    {processing && (
                                        <LoaderCircle className="h-4 w-4 animate-spin" />
                                    )}
                                    إرسال رابط إعادة تعيين كلمة المرور
                                </Button>
                            </div>
                        </>
                    )}
                </Form>

                <div className="space-x-1 text-center text-sm text-muted-foreground">
                    <span>أو، عُد إلى</span>
                    <TextLink href={login()}>تسجيل الدخول</TextLink>
                </div>
            </div>
        </AuthLayout>
    );
}
