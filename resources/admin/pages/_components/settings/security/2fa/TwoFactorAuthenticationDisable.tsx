import { Button } from "@/components/ui/button";
import { CardContent, CardDescription, CardFooter } from "@/components/ui/card";
import { disable, recoveryCodes, regenerateRecoveryCodes } from "@/routes/admin/two-factor";
import { Link } from "@inertiajs/react";
import axios from "axios";
import { CheckCheckIcon, CopyIcon, DownloadIcon } from "lucide-react";
import { useState } from "react";


export default function TwoFactorAuthenticationDisable() {
    const [copied, setCopied] = useState(false);
    const [recoveryCodesVisible, setRecoveryCodesVisible] = useState<string[] | undefined>();

    const getRecoveryCodes = () => {
        if (!recoveryCodesVisible) {
            axios.get(recoveryCodes.url()).then(response => {
                console.log(response.data);
                setRecoveryCodesVisible(response.data);
            });
        }
    };

    const renewalRecoveryCodes = () => {
        axios.post(regenerateRecoveryCodes.url()).then(response => {
            console.log(response.data);
            setRecoveryCodesVisible(response.data);
        });
    }
    const handleCopy = () => {
        const codes = recoveryCodesVisible?.join('\n') ?? '';
        navigator.clipboard.writeText(codes);
        setCopied(true);
        setTimeout(() => setCopied(false), 2000);
    };

    const hundleDownload = () => {
        const codes = recoveryCodesVisible?.join('\n') ?? '';
        const element = document.createElement("a");
        const file = new Blob([codes], { type: 'text/plain' });
        element.href = URL.createObjectURL(file);
        element.download = "recovery-codes.txt";
        document.body.appendChild(element);
        element.click();
        document.body.removeChild(element);
    }

    return (
        <>
            <CardContent>

                {
                    recoveryCodesVisible && (
                        <>
                            <CardDescription>
                                احفظ رموز الاسترداد هذه في مدير كلمات مرور آمن. يمكنك استخدامها لاستعادة الوصول إلى حسابك في حال فقدان جهاز المصادقة الثنائية.
                            </CardDescription>
                            <code className="relative">
                                <ul className="px-3 py-4 bg-background rounded-md mt-4">
                                    {
                                        recoveryCodesVisible?.map((code, idx) => (
                                            <li key={idx}>
                                                {code}
                                            </li>
                                        ))
                                    }
                                </ul>
                                <div className="flex items-center gap-4 absolute top-4 left-3">
                                    <Button variant="ghost" size="icon" className="bg-accent !size-2.5 cursor-pointer p-1" onClick={hundleDownload}>
                                        <DownloadIcon size={10} />
                                    </Button>
                                    <Button variant="ghost" size="icon" className="bg-accent !size-2.5 cursor-pointer p-1" onClick={handleCopy}>
                                        {copied ? <CheckCheckIcon size={10} /> : <CopyIcon size={10} />}
                                    </Button>
                                </div>
                            </code>
                        </>
                    )
                }
            </CardContent>
            <CardFooter className="flex justify-end gap-5">
                <Link href={disable.delete().url} className="h-9 px-4 py-2 has-[>svg]:px-3 bg-destructive text-white shadow-xs hover:bg-destructive/90 dark:focus-visible:ring-destructive/40 inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium transition-[color,box-shadow] disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg:not([class*='size-'])]:size-4 [&_svg]:shrink-0 outline-none focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px] aria-invalid:ring-destructive/20 dark:aria-invalid:ring-destructive/40 aria-invalid:border-destructive" method={disable.delete().method} as="button" data={{}} preserveScroll>
                    تعطيل
                </Link>
                {
                    !recoveryCodesVisible ? (
                        <Button variant="outline" className="flex items-center gap-2" onClick={getRecoveryCodes}>
                            عرض رموز الاسترداد
                        </Button>
                    ) : (
                        <Button variant="outline" className="flex items-center gap-2" onClick={renewalRecoveryCodes}>
                            تجديد رموز الاسترداد
                        </Button>
                    )
                }
            </CardFooter>
        </>
    );
}
