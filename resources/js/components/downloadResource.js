import { DownloadManager } from "@/lib/download";
import { download } from "@client/routes/client/library";

export default function downloadResource(isDownloading = false, ulid = null, title = null) {
    return {
        isDownloading: isDownloading,
        ulid: ulid,
        isLoading: false,
        precent: 0,
        errorMessage: null,
        isStart: false,
        title: title,
        isComplete: false,

        startDownload() {
            // منع التكرار أثناء التحميل
            if (this.isLoading) return;
            const url = download(this.ulid).url;
            const downloader = new DownloadManager(url, this.title ?? "file", {
                onStart: () => {
                    this.isLoading = true;
                    this.isStart = true;
                    this.isComplete = false;
                    this.errorMessage = null;
                    this.precent = 0;
                },
                onProgress: (percent) => {
                    this.precent = percent;
                },
                onSuccess: () => {
                    this.isLoading = false;
                    this.isStart = false;
                    this.precent = 100;
                    this.isComplete = true;
                    this.errorMessage = null;

                    // بعد 5 ثواني يرجع isComplete إلى false
                    setTimeout(() => {
                        this.isComplete = false;
                    }, 5000);
                },
                onError: (error) => {
                    this.isLoading = false;
                    this.isStart = false;
                    this.errorMessage = error?.message || 'Download failed';
                    this.precent = 0;
                    this.isComplete = false;

                    // بعد 5 ثواني تختفي رسالة الخطأ
                    setTimeout(() => {
                        this.errorMessage = null;
                    }, 5000);
                },
            });

            downloader.start();
        }
    }
}
