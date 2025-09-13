import { Membership } from "@/types/model/membership.d";
import { clsx, type ClassValue } from "clsx"
import { twMerge } from "tailwind-merge"

export function cn(...inputs: ClassValue[]) {
    return twMerge(clsx(inputs))
}

export function translateField(
    item: Membership,
    field: keyof Membership,
    isTranslate: boolean
) {
    if (!item) {
        return "";
    }
    const key = `${field}` as keyof Membership;
    const fallbackKey = `${field}_en` as keyof Membership;
    let defaultValue: any = "";
    if (Array.isArray(item[key])) {
        defaultValue = [];
    }
    if (isTranslate) {
        return (item[fallbackKey] as any) ?? (item[key] as any) ?? defaultValue;
    }
    return (item[key] as any) ?? defaultValue;
}



export function isIsoDate(value: any) {
    if (typeof value !== "string") return false;
    const isoDateRegex = /^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}(?:\.\d+)?Z?$/;
    return isoDateRegex.test(value);
}


export function formatDate(value: string) {
    const date = new Date(value);
    if (isNaN(date.getTime())) return value;
    const day = String(date.getDate()).padStart(2, "0");
    const month = String(date.getMonth() + 1).padStart(2, "0");
    const year = date.getFullYear();
    const hours = String(date.getHours()).padStart(2, "0");
    const minutes = String(date.getMinutes()).padStart(2, "0");
    return `${hours}:${minutes} ${year}-${month}-${day}`;
}


export function isEmptyObject(obj: object) {
    return Object.keys(obj).length === 0 && obj.constructor === Object;
}


export function formatterNumber(value: number | string, locale = "ar-SA", currency = "SAR") {
    const num = typeof value === "string" ? Number(value) : value;
    if (!Number.isFinite(num)) return String(value);
    const formatterNumber = new Intl.NumberFormat("ar-SA", {
        style: "currency",
        currency: "SAR",
        currencyDisplay: "narrowSymbol",
        minimumFractionDigits: 0,
        maximumFractionDigits: 0,
    });
    const parts = formatterNumber.formatToParts(Number(num));
    const valueOnly = parts.filter(p => p.type !== "currency").map(p => p.value).join("").trim();
    return valueOnly;
}


type TimeUnit = "day" | "week" | "month";
export function formatTimeUnit(count: number | string, unit: TimeUnit): string {
  const n = typeof count === "string" ? parseInt(count, 10) : count;
  if (isNaN(n) || n < 0) return "";

  const map: Record<TimeUnit, [string, string, string, string]> = {
    day: ["يوم", "يومان", "أيام", "يومًا"],
    week: ["أسبوع", "أسبوعان", "أسابيع", "أسبوعًا"],
    month: ["شهر", "شهران", "أشهر", "شهرًا"],
  };

  const [singular, dual, plural3to10, pluralOver10] = map[unit];

  if (n === 1) return singular;
  if (n === 2) return dual;
  if (n >= 3 && n <= 10) return `${n} ${plural3to10}`;
  return `${n} ${pluralOver10}`;
}



/**
 * تحويل بايت إلى صيغة قابلة للقراءة (KB, MB, GB, TB)
 * @param bytes الحجم بالبايت
 * @param decimals عدد الأرقام العشرية
 * @returns الحجم بصيغة قابلة للقراءة
 */
export function formatBytes(bytes: number, decimals = 2) {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const dm = decimals < 0 ? 0 : decimals;
    const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
}


/**
 * ارجع رساله الخطأ من استجابة الخطأ
 * @param status كود حالة الخطأ
 * @param field اسم الحقل الذي حدث فيه الخطأ
 * @returns رسالة الخطأ كنص
 */
export function getErrorMessage(status: number, field?: string): string {
    switch (status) {
        case 0:
            return "تعذر الاتصال بالخادم. يرجى التحقق من اتصالك بالإنترنت.";
        case 400:
            return `طلب غير صالح ${field ?? ""}.`;
        case 401:
            return "غير مصرح. يرجى تسجيل الدخول.";
        case 403:
            return `ليس لديك صلاحية حذف هذه ${field ?? "المورد"}.`;
        case 404:
            return `${field ?? "المورد"} غير موجودة أو تم حذفها مسبقاً.`;
        case 422:
            return `خطأ في التحقق من الصحة${field ?? "المورد"}.`;
        case 429:
            return "تم تجاوز الحد المسموح من الطلبات. يرجى المحاولة لاحقاً.";
        case 500:
            return `حدث خطأ في الخادم أثناء محاولة معالجة ${field}. يرجى المحاولة لاحقاً.`;
        case 503:
            return "الخدمة غير متوفرة. حاول مرة أخرى لاحقًا.";
        default:
            return "حدث خطأ غير متوقع. حاول مرة أخرى.";
    }
}

