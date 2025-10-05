import messages from '../lang/ar.json' assert { type: 'json' };

export function translate(key) {
    const isArabic = document.documentElement.lang === "ar";
    if (isArabic) {
        return messages[key] || key;
    }
    return key;
}
