// Components
import { store } from '@/actions/App/Http/Controllers/Auth/EmailVerificationNotificationController';
import { logout } from '@/routes/admin';
import { Form, Head } from '@inertiajs/react';
import { LoaderCircle } from 'lucide-react';

import TextLink from '@/components/text-link';
import { Button } from '@/components/ui/button';
import AuthLayout from '@/layouts/auth-layout';
import { type AuthProps } from '@/types/shared/auth';

export default function VerifyEmail({ status }: AuthProps) {
    return (
        <AuthLayout title="تأكيد البريد الإلكتروني" description="يرجى تأكيد بريدك الإلكتروني من خلال النقر على الرابط الذي أرسلناه إليك.">
            <Head title="تأكيد البريد الإلكتروني" />

            {status === 'verification-link-sent' && (
                <div className="mb-4 text-center text-sm font-medium text-green-600">
                    تم إرسال رابط تحقق جديد إلى البريد الإلكتروني الذي أدخلته أثناء التسجيل.
                </div>
            )}

            <Form {...store.form()} className="space-y-6 text-center">
                {({ processing }) => (
                    <>
                        <Button disabled={processing} variant="secondary">
                            {processing && <LoaderCircle className="h-4 w-4 animate-spin" />}
                            إعادة إرسال رابط التحقق
                        </Button>

                        <TextLink href={logout()} className="mx-auto block text-sm">
                            تسجيل الخروج
                        </TextLink>
                    </>
                )}
            </Form>
        </AuthLayout>
    );
}
