import { useEffect, useState } from "react";
import { Upload, X } from "lucide-react";
import { Progress } from "@/components/ui/progress";
import { cn } from "@/lib/utils";
import { Button } from "@/components/ui/button";
import { toast } from "sonner";
import axios from "axios";
import { checkUploadedChunks, deleteFile, stream } from "@/routes/admin/library";

axios.defaults.headers.common["X-CSRF-TOKEN"] =
    document.querySelector('meta[name="csrf-token"]')?.getAttribute("content") || "";

function FileUpload({ onUploaded, disabled, setDisabled }: { onUploaded: (path: string) => void; disabled: boolean; setDisabled: (v: boolean) => void }) {
    const [file, setFile] = useState<File | null>(null);
    const [progress, setProgress] = useState<number>(0);
    const [uploading, setUploading] = useState(false);
    const [uploadedPath, setUploadedPath] = useState<string | null>(null);
    const [error, setError] = useState<string | null>(null);
    const CHUNK_SIZE = 5 * 1024 * 1024;

    const buildUploadHash = async (f: File) => {
        const payload = [f.name, f.size, f.type || "", f.lastModified || 0].join("|");
        const bytes = new TextEncoder().encode(payload);
        const hashBuffer = await crypto.subtle.digest("SHA-256", bytes);
        return Array.from(new Uint8Array(hashBuffer))
            .map((byte) => byte.toString(16).padStart(2, "0"))
            .join("");
    };

    useEffect(() => {
        const handleBeforeUnload = (e: BeforeUnloadEvent) => {
            if (uploading) {
                e.preventDefault();
            }
        };

        window.addEventListener("beforeunload", handleBeforeUnload);
        return () => window.removeEventListener("beforeunload", handleBeforeUnload);
    }, [uploading]);

    // 🔸 عند محاولة إرسال أي فورم
    useEffect(() => {
        const handleFormSubmit = (e: Event) => {
            if (uploading) {
                const confirmLeave = window.confirm("يوجد رفع جاري، هل تريد المتابعة؟");
                if (!confirmLeave) e.preventDefault();
            }
        };

        document.addEventListener("submit", handleFormSubmit);
        return () => document.removeEventListener("submit", handleFormSubmit);
    }, [uploading]);

    const handleDrop = (e: React.DragEvent<HTMLDivElement>) => {
        e.preventDefault();
        const f = e.dataTransfer.files?.[0];
        if (f) uploadFile(f);
    };

    const handleChange = (e: React.ChangeEvent<HTMLInputElement>) => {
        const f = e.target.files?.[0];
        if (f) uploadFile(f);
    };

    const uploadFile = async (f: File) => {
        setFile(f);
        setUploading(true);
        setDisabled(true);
        setProgress(0);
        setError(null);

        const totalChunks = Math.ceil(f.size / CHUNK_SIZE);
        const uploadHash = await buildUploadHash(f);
        let res: any;
        let completedSuccessfully = false;

        try {
            // 🟢 تحقق أولاً من الأجزاء المرفوعة مسبقًا عبر manifest
            const manifestCheck = await axios.get(checkUploadedChunks().url, {
                params: {
                    filename: f.name,
                    total: totalChunks,
                    file_size: f.size,
                    upload_hash: uploadHash,
                },
            });

            const serverState = manifestCheck.data || {};
            const uploadedSet = new Set<number>((serverState.uploaded_chunks || []).map((index: number) => Number(index)));

            if (serverState.done && serverState.final_path) {
                setProgress(100);
                setUploadedPath(serverState.final_path);
                onUploaded(serverState.final_path);
                toast.success("✅ الملف موجود ومكتمل مسبقًا!");
                completedSuccessfully = true;
                return;
            }

            for (let i = 0; i < totalChunks; i++) {
                // تخطي الجزء الموجود مسبقاً
                if (uploadedSet.has(i)) {
                    console.log(`✅ الجزء ${i} موجود مسبقًا`);
                    setProgress(Math.round(((i + 1) / totalChunks) * 100));
                    continue;
                }

                const start = i * CHUNK_SIZE;
                const end = Math.min(f.size, start + CHUNK_SIZE);
                const chunk = f.slice(start, end);

                const formData = new FormData();
                formData.append("file", chunk);
                formData.append("index", i.toString());
                formData.append("total", totalChunks.toString());
                formData.append("filename", f.name);
                formData.append("file_size", f.size.toString());
                formData.append("upload_hash", uploadHash);

                res = await axios.post(stream().url, formData, {
                    headers: { "Content-Type": "multipart/form-data" },
                    onUploadProgress: (e) => {
                        if (e.total) {
                            const percent = Math.round(((i + e.loaded / e.total) / totalChunks) * 100);
                            setProgress(percent);
                            console.log(`📤 رفع ${Math.min(i * CHUNK_SIZE + e.loaded, f.size)} / ${f.size} bytes`);
                        }
                    },
                }).then((r) => r.data);
            }

            const finalPath = res?.final_path || res?.file_path || null;

            if (finalPath) {
                toast.success("✅ تم رفع الملف بنجاح!");
                console.log(finalPath);
                onUploaded(finalPath);
                setUploadedPath(finalPath);
                setProgress(100);
                completedSuccessfully = true;
            } else {
                toast.success("✅ تم رفع الملف بنجاح!");
            }

        } catch (err) {
            console.error("❌ خطأ أثناء رفع الملف:", err);
            const message = axios.isAxiosError(err)
                ? (err.response?.data?.message || "فشل رفع الملف")
                : "فشل رفع الملف";
            setError(message);
            toast.error(`❌ ${message}`);
            setFile(null);
        } finally {
            setUploading(false);
            setDisabled(false);
            if (!completedSuccessfully) {
                setProgress(0);
            }
        }
    };

    // 🟥 حذف الملف من السيرفر أو إلغاء التحديد
    const handleRemove = async () => {
        if (!file) {
            setFile(null);
            setProgress(0);
            setError(null);
            return;
        }
        setDisabled(true); try {
            await axios.post(deleteFile().url, { file_path: uploadedPath });
            setFile(null);
            setUploadedPath(null);
            setProgress(0);
            onUploaded("");
            toast.success("🗑️ تم حذف الملف بنجاح!");
        } catch (err) {
            console.error(err);
            toast.error("❌ فشل حذف الملف من السيرفر!");
        } finally { setDisabled(false); }
    };

    return (
        <div
            onDrop={handleDrop}
            onDragOver={(e) => e.preventDefault()}
            className={cn(
                "border-2 border-dashed rounded-xl p-4 text-center cursor-pointer transition",
                uploading ? "border-primary/50 bg-primary/5" : "hover:bg-muted border-muted-foreground/30"
            )}
        >
            {!file && (
                <>
                    <Upload className="mx-auto mb-2 text-muted-foreground" />
                    <p className="text-sm text-muted-foreground">
                        اسحب الملف هنا أو{" "}
                        <label className="text-primary cursor-pointer">
                            اختره يدويًا
                            <input type="file" name="file" onChange={handleChange} className="hidden" disabled={disabled} />
                        </label>
                        <br />
                        (الحد الأقصى المسموح به 255 ميجابايت)
                    </p>
                </>
            )}

            {file && (
                <div className="flex flex-col items-center gap-2">
                    <div className="flex items-center gap-2 text-sm font-medium">
                        <span>{file.name}</span>
                        {!uploading && (
                            <Button variant="ghost" size="icon" onClick={() => { handleRemove(); }} disabled={disabled}>
                                <X className="h-4 w-4" />
                            </Button>
                        )}
                    </div>

                    {uploading && (
                        <div className="w-full flex flex-col gap-2">
                            <Progress value={progress} />
                            <span className="text-xs text-muted-foreground">جاري الرفع... {progress}%</span>
                        </div>
                    )}
                </div>
            )}
        </div>
    );
}

export default FileUpload;
