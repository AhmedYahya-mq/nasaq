import axios, { AxiosRequestConfig, AxiosProgressEvent } from "axios";

export type DownloadCallbacks = {
  onStart?: () => void;
  onProgress?: (percent: number) => void;
  onSuccess?: () => void;
  onError?: (error: any) => void;
};

export class DownloadManager {
  private url: string;
  private fileName?: string;
  private callbacks?: DownloadCallbacks;
  private config: AxiosRequestConfig;
  private isDownloading: boolean = false;

  constructor(url: string, fileName?: string, callbacks?: DownloadCallbacks) {
    this.url = url;
    this.fileName = fileName;
    this.callbacks = callbacks;

    this.config = {
      responseType: "blob",
      onDownloadProgress: this.handleProgress.bind(this),
    };
  }

  /**
   * بدء عملية التحميل
   */
  public async start() {
    try {
      this.isDownloading = true;
      this.enableBeforeUnload();

      this.callbacks?.onStart?.();
      const response = await axios.get<Blob>(this.url, this.config);

      const finalName = this.getFileName(response);

      this.saveBlob(response.data, finalName);

      this.callbacks?.onSuccess?.();
    } catch (error) {
      this.callbacks?.onError?.(error);
      console.error("Download error:", error);
    } finally {
      this.isDownloading = false;
      this.disableBeforeUnload();
    }
  }

  /**
   * متابعة تقدم التحميل
   */
  private handleProgress(progressEvent: AxiosProgressEvent) {
    const loaded = progressEvent.loaded ?? 0;
    const total = progressEvent.total ?? 0;
    const percent = total ? Math.round((loaded * 100) / total) : 0;
    this.callbacks?.onProgress?.(percent);
  }

  /**
   * استخراج اسم الملف النهائي من headers أو استخدام الاسم الافتراضي
   */
  private getFileName(response: { headers: any }): string {
    let name = this.fileName ?? "file";

    const ext = typeof response.headers["content-extension"] === "string" ? response.headers["content-extension"] : undefined;
    const contentDisposition = typeof response.headers["content-disposition"] === "string" ? response.headers["content-disposition"] : undefined;

    if (ext) {
      name += `.${ext}`;
    } else if (contentDisposition) {
      const match = contentDisposition.match(/filename="?([^"]+)"?/);
      if (match?.[1]) {
        name = match[1];
      }
    }

    return name;
  }

  /**
   * حفظ الملف على الجهاز باستخدام رابط مؤقت
   */
  private saveBlob(blobData: BlobPart, fileName: string) {
    const blob = new Blob([blobData]);
    const link = document.createElement("a");
    link.href = URL.createObjectURL(blob);
    link.download = fileName;
    document.body.appendChild(link); // لبعض المتصفحات القديمة
    link.click();
    link.remove();
    URL.revokeObjectURL(link.href);
  }

  /**
   * تفعيل تحذير عند إغلاق أو إعادة تحميل الصفحة أثناء التحميل
   */
  private enableBeforeUnload() {
    window.addEventListener("beforeunload", this.beforeUnloadHandler, { capture: true });
  }

  private disableBeforeUnload() {
    window.removeEventListener("beforeunload", this.beforeUnloadHandler);
  }

  private beforeUnloadHandler = (e: BeforeUnloadEvent) => {
    if (this.isDownloading) {
      e.preventDefault(); // الطريقة الحديثة
      // المتصفح سيعرض رسالة التأكيد الافتراضية
      // لا حاجة لاستخدام returnValue لأنه Deprecated
    }
  };
}
