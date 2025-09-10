/**
 * Format a date string or Date object into a specific format
 * @param {string|Date} dateInput - تاريخ أو سترينج يمكن تحويله إلى Date
 * @param {string} format - الصيغة المطلوبة: "YYYY-MM-DD", "DD/MM/YYYY", "MM-DD-YYYY"
 * @returns {string} التاريخ بعد الفورمات
 */
export function formatDate(dateInput, format = "YYYY-MM-DD") {
    const date = new Date(dateInput);
    if (isNaN(date)) return null; // لو التاريخ غير صالح

    const day = String(date.getDate()).padStart(2, "0");
    const month = String(date.getMonth() + 1).padStart(2, "0"); // شهور من 0-11
    const year = date.getFullYear();

    switch (format) {
        case "DD/MM/YYYY":
            return `${day}/${month}/${year}`;
        case "MM-DD-YYYY":
            return `${month}-${day}-${year}`;
        case "YYYY-MM-DD":
        default:
            return `${year}-${month}-${day}`;
    }
}
