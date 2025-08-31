import { Form, Head } from '@inertiajs/react';
import { LoaderCircle } from 'lucide-react';

import InputError from '@/components/input-error';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AuthLayout from '@/layouts/auth-layout';
import { store } from '@/routes/admin/password';
import { type ResetPasswordProps } from '@/types/shared/auth';



export default function ResetPassword({ token, email }: ResetPasswordProps) {
    return (
        <AuthLayout title="إعادة تعيين كلمة المرور" description="يرجى إدخال كلمة المرور الجديدة أدناه">
            <Head title="إعادة تعيين كلمة المرور" />

            <Form {...store.form()} transform={(data) => ({ ...data, token, email })} resetOnSuccess={['password', 'password_confirmation']}>
                {({ processing, errors }) => (
                    <div className="grid gap-6">
                        <div className="grid gap-2">
                            <Label htmlFor="email">البريد الإلكتروني</Label>
                            <Input id="email" type="email" name="email" autoComplete="email" value={email} className="mt-1 block w-full" readOnly />
                            <InputError message={errors.email} className="mt-2" />
                        </div>

                        <div className="grid gap-2">
                            <Label htmlFor="password">كلمة المرور الجديدة</Label>
                            <Input
                                id="password"
                                type="password"
                                name="password"
                                autoComplete="new-password"
                                className="mt-1 block w-full"
                                autoFocus
                                placeholder="كلمة المرور"
                            />
                            <InputError message={errors.password} />
                        </div>

                        <div className="grid gap-2">
                            <Label htmlFor="password_confirmation">تأكيد كلمة المرور</Label>
                            <Input
                                id="password_confirmation"
                                type="password"
                                name="password_confirmation"
                                autoComplete="new-password"
                                className="mt-1 block w-full"
                                placeholder="تأكيد كلمة المرور"
                            />
                            <InputError message={errors.password_confirmation} className="mt-2" />
                        </div>

                        <Button type="submit" className="mt-4 w-full" disabled={processing}>
                            {processing && <LoaderCircle className="h-4 w-4 animate-spin" />}
                            إعادة تعيين كلمة المرور
                        </Button>
                    </div>
                )}
            </Form>
        </AuthLayout>
    );
}
