
import TwoFactorAuthenticationEnable from './TwoFactorAuthenticationEnable';
import TwoFactorAuthenticationDisable from './TwoFactorAuthenticationDisable';
import HeadingSmall from '@/components/heading-small';
import TwoFactorAuthenticationConfirm from './TwoFactorAuthenticationConfirm';
import { Card, CardDescription, CardTitle } from '@/components/ui/card';
import { usePage } from '@inertiajs/react';
import { SharedData } from '@/types';
import { useEffect, useState } from 'react';

export default function TwoFactorAuth({ status }: { status?: string; }) {
    const { auth } = usePage<SharedData>().props;
    const [enabling, setEnabling] = useState(false);

    useEffect(() => {
        if (status && status === 'two-factor-authentication-enabled') {
            setEnabling(true);
        }

        if (status && (status === 'two-factor-authentication-disabled' || status === 'two-factor-authentication-confirmed')) {
            setEnabling(false);
        }
    }, [status]);

    return (
        <div className="space-y-6">
            <HeadingSmall title="المصادقه الثنائية" description="أضف أمانًا إضافيًا إلى حسابك باستخدام المصادقة الثنائية." />
            <Card className='sm:p-5 p-4'>
                <CardTitle>
                    {
                        auth.user.two_factor_enabled ? 'لقد قمت بتفعيل المصادقة الثنائية.' : enabling ? 'أنت في طور تفعيل المصادقة الثنائية.' : 'لم تقم بتفعيل المصادقة الثنائية.'
                    }
                </CardTitle>
                <CardDescription>
                    عند تفعيل المصادقة الثنائية، سيتم مطالبتك برمز آمن وعشوائي أثناء المصادقة. يمكنك استرداد هذا الرمز من تطبيق Google Authenticator على هاتفك.
                </CardDescription>
                {
                    auth.user.two_factor_enabled ? (<TwoFactorAuthenticationDisable />) :
                        enabling ? (
                            <TwoFactorAuthenticationConfirm  />
                        ) : (
                            <TwoFactorAuthenticationEnable />
                        )
                }
            </Card>
        </div>
    );
}
