/**
 * تضغط أي صورة وتحولها إلى WebP باستخدام canvas
 * @param {File} file - ملف الصورة
 * @param {Object} options - إعدادات الضغط { maxWidth, maxHeight, quality }
 * @returns {Promise<File>} ملف WebP مضغوط
 */
export async function compressToWebP(file, options = {}) {
  if (!file || !file.type.startsWith('image/')) {
    throw new Error('الملف المدخل ليس صورة صالحة');
  }

  const { maxWidth = 1024, maxHeight = 1024, quality = 0.8 } = options;

  return new Promise((resolve, reject) => {
    const img = new Image();
    img.onload = () => {
      let { width, height } = img;
      const ratio = Math.min(maxWidth / width, maxHeight / height, 1);
      width = width * ratio;
      height = height * ratio;
      const canvas = document.createElement('canvas');
      canvas.width = width;
      canvas.height = height;
      const ctx = canvas.getContext('2d');
      ctx.drawImage(img, 0, 0, width, height);
      canvas.toBlob(
        (blob) => {
          if (!blob) return reject(new Error('فشل تحويل الصورة'));
          const compressedFile = new File([blob], 'profile.webp', { type: 'image/webp' });
          resolve(compressedFile);
        },
        'image/webp',
        quality
      );
    };
    img.onerror = () => reject(new Error('فشل تحميل الصورة'));
    img.src = URL.createObjectURL(file);
  });
}
