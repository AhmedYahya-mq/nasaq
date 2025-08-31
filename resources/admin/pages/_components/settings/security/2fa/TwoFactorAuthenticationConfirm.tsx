
import InputError from "@/components/input-error";
import { Button } from "@/components/ui/button";
import { CardContent } from "@/components/ui/card";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import { Skeleton } from "@/components/ui/skeleton";
import { confirm, qrCode, secretKey } from "@/routes/admin/two-factor";
import { Form } from "@inertiajs/react";
import axios from "axios";
import { CheckCheckIcon, CopyIcon } from "lucide-react";
import { useEffect, useState } from "react";

export default function TwoFactorAuthenticationConfirm() {
    const [copied, setCopied] = useState(false);
    const [qrCodeSvg, setQrCodeSvg] = useState<string | undefined>();
    const [setupKey, setSecretKey] = useState<string | undefined>();

    useEffect(() => {
        if (!qrCodeSvg) {
            axios.get(qrCode.url()).then(response => {
                setQrCodeSvg(response.data.svg);
            });
        }
        if (!setupKey) {
            axios.get(secretKey.url()).then(response => {
                setSecretKey(response.data.secretKey);
            });
        }
    }, []);

    const handleCopy = () => {
        navigator.clipboard.writeText(setupKey ?? "");
        setCopied(true);
        setTimeout(() => setCopied(false), 2000);
    };

    return (
        <>
            <CardContent className="mt-4">
                <ol className="list-decimal list-inside space-y-6">
                    <li>
                        افتح تطبيق المصادقة على هاتفك مثل Google Authenticator أو Microsoft Authenticator أو Authy.
                    </li>
                    <li>
                        امسح رمز الـQR الذي يظهر لك، أو أدخل مفتاح الإعداد يدويًا إذا لم تتمكن من المسح.
                        {
                            !qrCodeSvg ? (
                                <div className="mt-2">
                                    <Skeleton className="h-32 w-32" />
                                </div>
                            ) : (
                                <div className="mt-2 *:bg-white *:inline-block *:p-2" dangerouslySetInnerHTML={{ __html: `<div >${qrCodeSvg}</div>` }} />
                            )
                        }
                        <div className="mt-2 flex items-center gap-2">
                            <span>مفتاح الإعداد:</span>
                            {
                                !setupKey ? (
                                    <Skeleton className="h-4 w-[200px]" />
                                ) : (<code className="bg-background px-3 py-1 rounded-md gap-4 flex items-center">
                                    <span>{setupKey}</span>
                                    <Button variant="ghost" size="icon" className="bg-background !size-2.5 cursor-pointer p-1" onClick={handleCopy}>
                                        {copied ? <CheckCheckIcon size={10} /> : <CopyIcon size={10} />}
                                    </Button>
                                </code>)
                            }

                        </div>
                    </li>
                    <li>
                        أدخل الرمز المكون من 6 أرقام الذي يولده التطبيق ثم اضغط على "تأكيد".
                        <Form
                            {...confirm.form()}
                            options={{ preserveScroll: true }}
                            className="mt-2 space-y-4"
                            errorBag="confirmTwoFactorAuthentication"
                            resetOnSuccess
                            disableWhileProcessing
                        >
                            {({ processing, errors }) => (
                                <>
                                    <div className="grid gap-2">
                                        <Label htmlFor="code" className="sr-only">رمز التحقق</Label>
                                        <Input
                                            id="code"
                                            type="text"
                                            name="code"
                                            placeholder="رمز التحقق"
                                            autoComplete="one-time-code"
                                        />

                                        <InputError message={errors.code} />
                                    </div>

                                    <Button type="submit" disabled={processing}>
                                        تأكيد
                                    </Button>
                                </>
                            )}
                        </Form>
                    </li>
                </ol>
            </CardContent>
        </>
    );
}
