import { Loader2 } from "lucide-react";
import { useState } from "react";
import { toast } from "sonner";

function ProgressToast({ progress }: { progress: number }) {
    return (
        <div className="flex flex-col p-4 bg-card rounded-xl shadow-lg w-72 animate-fade-in border">
            <div className="flex items-center justify-between mb-2">
                <div className="flex items-center gap-2">
                    <Loader2 className="w-5 h-5 animate-spin text-primary" />
                    <span className="font-medium text-muted-foreground text-sm">جاري تحميل الملف...</span>
                </div>
                <span className="text-xs text-accent-foreground">{progress}%</span>
            </div>
            <div className="h-2 w-full bg-muted rounded-full overflow-hidden">
                <div
                    className="h-full bg-primary rounded-full transition-all duration-300"
                    style={{ width: `${progress}%` }}
                ></div>
            </div>
        </div>
    );
}

export default function useProgressToast() {
    const [progress, setProgress] = useState(0);
    const [toastId, setToastId] = useState<string | number>('download-progress');

    const showToast = () => {
        toast.custom(() => <ProgressToast progress={progress} />, {
            id: toastId,
            duration: Infinity,
        });
    };

    const updateProgress = (value: number) => {
        setProgress(value);
        toast.custom(() => <ProgressToast progress={value} />, { id: toastId, duration: Infinity });

    };

    const removeToast = () => {
        toast.dismiss(toastId);
        setProgress(0);
    };

    return { showToast, updateProgress, removeToast, progress };
}
