import React, { useState, useRef, useCallback } from 'react';
import { useDropzone, type FileRejection, type Accept } from 'react-dropzone';
import axios, { type AxiosProgressEvent } from 'axios';

type UploadStatus = 'pending' | 'uploading' | 'completed' | 'error';

type FileItem = {
  id: string;
  file: File;
  name: string;
  size: number;
  type: string;
  preview: string | null;
  progress: number;
  status: UploadStatus;
  url?: string;
};

type FileUploaderProps = {
  multiple?: boolean;
  maxFileSize?: number;
  acceptedFileTypes?: string[];
  uploadUrl?: string;
  deleteUrl?: string;
};

const FileUploader = ({
  multiple = false,
  maxFileSize = 5 * 1024 * 1024, // 5MB افتراضيًا
  acceptedFileTypes = ['image/*', 'application/pdf'],
  uploadUrl = '/upload',
  deleteUrl = '/delete'
}: FileUploaderProps) => {
  const [files, setFiles] = useState<FileItem[]>([]);
  const [isDragging, setIsDragging] = useState(false);
  const fileInputRef = useRef<HTMLInputElement | null>(null);

  // معالجة اختيار الملفات
  const handleFiles = useCallback((acceptedFiles: File[], rejectedFiles: FileRejection[]) => {
    if (rejectedFiles && rejectedFiles.length > 0) {
      alert('بعض الملفات مرفوضة. تأكد من الحجم والنوع المسموح به.');
      return;
    }

    const newFiles: FileItem[] = acceptedFiles.map((file) => ({
      file,
      name: file.name,
      size: file.size,
      type: file.type,
      preview: file.type.startsWith('image/') ? URL.createObjectURL(file) : null,
      progress: 0,
      status: 'pending', // pending, uploading, completed, error
      id: Math.random().toString(36).substr(2, 9)
    }));

    if (multiple) {
      setFiles((prev) => [...prev, ...newFiles]);
    } else {
      setFiles(newFiles);
    }

    // رفع الملفات تلقائيًا
    newFiles.forEach(uploadFile);
  }, [multiple, maxFileSize]);

  // إعداد منطقة السحب والإفلات
  const { getRootProps, getInputProps, isDragActive } = useDropzone({
    onDrop: handleFiles,
    onDragEnter: () => setIsDragging(true),
    onDragLeave: () => setIsDragging(false),
    onDropAccepted: () => setIsDragging(false),
    onDropRejected: () => setIsDragging(false),
    multiple,
    maxSize: maxFileSize,
    accept: acceptedFileTypes.reduce((acc, type) => {
      (acc as Record<string, string[]>)[type] = [];
      return acc;
    }, {} as Accept)
  });

  // رفع الملف إلى السيرفر
  const uploadFile = async (fileObj: FileItem) => {
    const formData = new FormData();
    formData.append('file', fileObj.file);

    setFiles((prev) => prev.map((f) =>
      f.id === fileObj.id ? { ...f, status: 'uploading' as UploadStatus } : f
    ));

    try {
      const response = await axios.post(uploadUrl, formData, {
        onUploadProgress: (progressEvent: AxiosProgressEvent) => {
          const total = progressEvent.total ?? 1;
          const progress = Math.round((Number(progressEvent.loaded) * 100) / total);
          setFiles((prev) => prev.map((f) =>
            f.id === fileObj.id ? { ...f, progress } : f
          ));
        }
      });

      setFiles((prev) => prev.map((f) =>
        f.id === fileObj.id ? {
          ...f,
          status: 'completed' as UploadStatus,
          progress: 100,
          url: response.data.url
        } : f
      ));
    } catch (error) {
      console.error('Upload error:', error);
      setFiles((prev) => prev.map((f) =>
        f.id === fileObj.id ? { ...f, status: 'error' as UploadStatus } : f
      ));
    }
  };

  // حذف الملف
  const deleteFile = async (fileId: string, fileUrl?: string) => {
    try {
      if (fileUrl) {
        await axios.delete(`${deleteUrl}?fileUrl=${encodeURIComponent(fileUrl)}`);
      }

      setFiles((prev) => prev.filter((f) => f.id !== fileId));
    } catch (error) {
      console.error('Delete error:', error);
      alert('حدث خطأ أثناء حذف الملف');
    }
  };

  // فتح نافذة اختيار الملفات
  const handleButtonClick = () => {
    fileInputRef.current?.click();
  };

  return (
    <div className="file-uploader w-full max-w-2xl mx-auto p-4">
      {/* منطقة السحب والإفلات */}
      <div
        {...getRootProps()}
        className={`border-2 border-dashed rounded-lg p-8 text-center cursor-pointer transition-colors
          ${isDragActive || isDragging
            ? 'border-blue-500 bg-blue-50'
            : 'border-gray-300 hover:border-gray-400'}`}
      >
        <input {...getInputProps()} ref={fileInputRef} />
        <div className="flex flex-col items-center justify-center space-y-4">
          <svg className="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2"
                  d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
          </svg>
          <p className="text-gray-600">
            {isDragActive
              ? 'أفلت الملفات هنا للرفع'
              : 'اسحب الملفات وأفلتها هنا، أو انقر للاختيار'}
          </p>
          <button
            type="button"
            onClick={handleButtonClick}
            className="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
          >
            اختيار الملفات
          </button>
          <p className="text-sm text-gray-500">
            {acceptedFileTypes.join(', ')} - الحد الأقصى للحجم: {maxFileSize / 1024 / 1024}MB
          </p>
        </div>
      </div>

      {/* قائمة الملفات */}
      <div className="mt-6 space-y-4">
        {files.map((file: FileItem) => (
          <div key={file.id} className="flex items-center justify-between p-4 bg-white rounded-lg shadow">
            <div className="flex items-center space-x-4 flex-1 min-w-0">
              {/* معاينة الصورة */}
              {file.preview && (
                <div className="flex-shrink-0">
                  <img
                    src={file.preview}
                    alt={file.name}
                    className="w-12 h-12 object-cover rounded"
                  />
                </div>
              )}

              {/* أيقونة الملف للأنواع الأخرى */}
              {!file.preview && (
                <div className="flex-shrink-0">
                  <svg className="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2"
                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                  </svg>
                </div>
              )}

              <div className="flex-1 min-w-0">
                <p className="text-sm font-medium text-gray-900 truncate">{file.name}</p>
                <p className="text-xs text-gray-500">
                  {(file.size / 1024).toFixed(1)} KB
                </p>

                {/* شريط التقدم */}
                {file.status === 'uploading' && (
                  <div className="mt-2 w-full bg-gray-200 rounded-full h-2">
                    <div
                      className="bg-blue-600 h-2 rounded-full"
                      style={{ width: `${file.progress}%` }}
                    />
                  </div>
                )}

                {/* رسائل الحالة */}
                {file.status === 'completed' && (
                  <p className="text-xs text-green-600 mt-1">تم الرفع بنجاح</p>
                )}
                {file.status === 'error' && (
                  <p className="text-xs text-red-600 mt-1">فشل في الرفع</p>
                )}
              </div>
            </div>

            {/* زر الحذف */}
            <button
              onClick={() => deleteFile(file.id, file.url)}
              className="text-red-500 hover:text-red-700 focus:outline-none"
              aria-label="حذف الملف"
            >
              <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2"
                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
              </svg>
            </button>

            {/* Input مخفي برابط الملف بعد الرفع */}
            {file.status === 'completed' && file.url && (
              <input type="hidden" name="uploadedFiles" value={file.url} />
            )}
          </div>
        ))}
      </div>
    </div>
  );
};

export default FileUploader;
