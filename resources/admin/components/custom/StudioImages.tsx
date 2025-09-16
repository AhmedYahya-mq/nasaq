import React, { useState, useMemo, useReducer, useCallback, useEffect, useRef, memo } from "react";
import { Button } from "@/components/ui/button";
import { Dialog, DialogContent, DialogDescription, DialogFooter, DialogHeader, DialogTitle } from "@/components/ui/dialog";
// If your project has an Input component, use it; otherwise the fallback <input> below will be used.
// import { Input } from "@/components/ui/input";
import OptimizedImage from "./OptimizedImage";

type ImageItem = {
    id: number | string;
    path: string;
    name?: string;
    width: number;
    height: number;
    selected?: boolean;
};

type UploadResult = { successful: { data?: ImageItem[] }; failed?: unknown };

type StudioImagesTexts = {
    title: string;
    subtitle: string;
    gallery: string;
    upload: string;
    refresh: string;
    reloading: string;
    loading: string;
    emptyTitle: string;
    emptyDescription: string;
    emptyAction: string;
    assignImage: string;
    selectImage: string;
    searchPlaceholder: string;
    reloadError: string;
    maxSelectedReached: string;
    uploading: string;
    uploadSuccess: (count: number) => string;
    uploadFailed: string;
};

type StudioImagesProps = {
    isOpen: boolean;
    onClose: () => void;
    fetchImages?: () => Promise<ImageItem[]>;
    onImageSelect: (image: ImageItem | ImageItem[]) => void | Promise<void>;
    onImageUpload?: (files: File[]) => Promise<UploadResult>;
    isMulti?: boolean;
    maxSelectable?: number;
    texts?: Partial<StudioImagesTexts>;
};

// i18n defaults
const defaultTexts: StudioImagesTexts = {
    title: "إدارة الصور",
    subtitle: "اختر صورة من المكتبة أو قم بتحميل صورة جديدة لتعيينها.",
    gallery: "معرض الصور",
    upload: "رفع صور",
    refresh: "تحديث",
    reloading: "جاري التحديث…",
    loading: "جاري التحميل…",
    emptyTitle: "لا توجد صور بعد",
    emptyDescription: "ابدأ برفع صورك لتظهر هنا.",
    emptyAction: "رفع صورة",
    assignImage: "تعيين صورة",
    selectImage: "تحديد الصورة",
    searchPlaceholder: "ابحث بالاسم…",
    reloadError: "فشل تحميل الصور",
    maxSelectedReached: "تم بلوغ الحد الأقصى للاختيار",
    uploading: "جاري الرفع…",
    uploadSuccess: (count: number) => `تم رفع ${count} صورة بنجاح`,
    uploadFailed: "فشل رفع الصور",
};

// -------------------- Reducer / Hook --------------------
type State = {
    activeTab: "view" | "upload";
    images: ImageItem[];
    isLoading: boolean;
    error: string | null;
    selected: Set<string | number>;
    search: string;
    // upload state (progress is simulated/indeterminate)
    uploading: boolean;
    uploadError: string | null;
    uploadSuccessCount: number;
    assignLoading: boolean;
    dragOver: boolean;
};

type Action =
    | { type: "SET_TAB"; tab: State["activeTab"] }
    | { type: "LOAD_START" }
    | { type: "LOAD_SUCCESS"; images: ImageItem[] }
    | { type: "LOAD_ERROR"; error: string }
    | { type: "SET_SEARCH"; search: string }
    | { type: "TOGGLE_SELECT"; id: string | number; isMulti: boolean; maxSelectable?: number }
    | { type: "CLEAR_SELECT" }
    | { type: "UPLOAD_START" }
    | { type: "UPLOAD_SUCCESS"; added: ImageItem[] }
    | { type: "UPLOAD_ERROR"; error: string }
    | { type: "UPLOAD_END" }
    | { type: "ASSIGN_START" }
    | { type: "ASSIGN_END" }
    | { type: "SET_DRAG_OVER"; value: boolean };

const initialState: State = {
    activeTab: "view",
    images: [],
    isLoading: false,
    error: null,
    selected: new Set(),
    search: "",
    uploading: false,
    uploadError: null,
    uploadSuccessCount: 0,
    assignLoading: false,
    dragOver: false,
};

function reducer(state: State, action: Action): State {
    switch (action.type) {
        case "SET_TAB":
            return { ...state, activeTab: action.tab };
        case "LOAD_START":
            return { ...state, isLoading: true, error: null };
        case "LOAD_SUCCESS":
            return { ...state, isLoading: false, images: action.images, error: null };
        case "LOAD_ERROR":
            return { ...state, isLoading: false, error: action.error };
        case "SET_SEARCH":
            return { ...state, search: action.search };
        case "TOGGLE_SELECT": {
            const next = new Set(state.selected);
            const isSelected = next.has(action.id);
            if (!action.isMulti) {
                // single-selection
                next.clear();
                if (!isSelected) next.add(action.id);
                else if (isSelected) next.delete(action.id);
                return { ...state, selected: next };
            }
            // multi-selection with optional max
            if (isSelected) {
                next.delete(action.id);
                return { ...state, selected: next };
            }
            const max = action.maxSelectable ?? Infinity;
            if (next.size >= max) {
                // ignore if max reached
                return state;
            }
            next.add(action.id);
            return { ...state, selected: next };
        }
        case "CLEAR_SELECT":
            return { ...state, selected: new Set() };
        case "UPLOAD_START":
            return { ...state, uploading: true, uploadError: null, uploadSuccessCount: 0 };
        case "UPLOAD_SUCCESS":
            return {
                ...state,
                images: [...action.added, ...state.images],
                uploadSuccessCount: action.added.length,
                uploadError: null,
            };
        case "UPLOAD_ERROR":
            return { ...state, uploadError: action.error };
        case "UPLOAD_END":
            return { ...state, uploading: false };
        case "ASSIGN_START":
            return { ...state, assignLoading: true };
        case "ASSIGN_END":
            return { ...state, assignLoading: false };
        case "SET_DRAG_OVER":
            return { ...state, dragOver: action.value };
        default:
            return state;
    }
}

function useStudioImages(
    isMulti: boolean,
    fetchImages?: () => Promise<ImageItem[]>,
    onImageUpload?: (files: File[]) => Promise<UploadResult>,
    maxSelectable?: number
) {
    const [state, dispatch] = useReducer(reducer, initialState);

    const loadImages = useCallback(async () => {
        if (!fetchImages) return;
        dispatch({ type: "LOAD_START" });
        try {
            const data = await fetchImages();
            dispatch({ type: "LOAD_SUCCESS", images: data });
        } catch (e: any) {
            dispatch({ type: "LOAD_ERROR", error: e?.message ?? defaultTexts.reloadError });
        }
    }, [fetchImages]);

    const toggleSelect = useCallback(
        (id: string | number) => {
            dispatch({ type: "TOGGLE_SELECT", id, isMulti, maxSelectable });
        },
        [isMulti, maxSelectable]
    );

    const handleFiles = useCallback(
        async (files: File[]) => {
            if (!onImageUpload || !files?.length) return;
            dispatch({ type: "UPLOAD_START" });
            try {
                // Simulate indeterminate progress while awaiting API
                const result = await onImageUpload(files);
                const newImages = result?.successful?.data ?? [];
                if (newImages.length) {
                    dispatch({ type: "UPLOAD_SUCCESS", added: newImages });
                } else {
                    dispatch({ type: "UPLOAD_ERROR", error: defaultTexts.uploadFailed });
                }
            } catch {
                dispatch({ type: "UPLOAD_ERROR", error: defaultTexts.uploadFailed });
            } finally {
                dispatch({ type: "UPLOAD_END" });
            }
        },
        [onImageUpload]
    );

    const filteredImages = useMemo(() => {
        const q = state.search.trim().toLowerCase();
        if (!q) return state.images;
        return state.images.filter((img) => {
            const nm = (img.name ?? "").toLowerCase();
            const idStr = String(img.id).toLowerCase();
            return nm.includes(q) || idStr.includes(q);
        });
    }, [state.images, state.search]);

    const selectedImages = useMemo(
        () => state.images.filter((img) => state.selected.has(img.id)),
        [state.images, state.selected]
    );

    return {
        state,
        dispatch,
        loadImages,
        toggleSelect,
        handleFiles,
        filteredImages,
        selectedImages,
    };
}

// -------------------- Subcomponents --------------------
const Toolbar = memo(function Toolbar({
    activeTab,
    setTab,
    refresh,
    isLoading,
    search,
    setSearch,
    t,
}: {
    activeTab: "view" | "upload";
    setTab: (tab: "view" | "upload") => void;
    refresh: () => void;
    isLoading: boolean;
    search: string;
    setSearch: (v: string) => void;
    t: StudioImagesTexts;
}) {
    return (
        <div className="flex gap-2">
            <Button variant={activeTab === "view" ? "default" : "outline"} onClick={() => setTab("view")}>
                {t.gallery}
            </Button>
            <Button variant={activeTab === "upload" ? "default" : "outline"} onClick={() => setTab("upload")}>
                {t.upload}
            </Button>
            <div className="ms-auto flex items-center gap-2">
                {/* Prefer shadcn <Input> if available */}
                {/* <Input placeholder={t.searchPlaceholder} value={search} onChange={(e) => setSearch(e.target.value)} className="w-48" /> */}
                <input
                    placeholder={t.searchPlaceholder}
                    value={search}
                    onChange={(e) => setSearch(e.target.value)}
                    className="w-48 h-9 px-3 py-1 border rounded-md bg-background"
                />
                <Button variant="outline" onClick={refresh} disabled={isLoading}>
                    {isLoading ? t.reloading : t.refresh}
                </Button>
            </div>
        </div>
    );
});

const ImageCard = memo(function ImageCard({
    image,
    selected,
    onToggle,
    selectLabel,
}: {
    image: ImageItem;
    selected: boolean;
    onToggle: (image: ImageItem) => void;
    selectLabel: string;
}) {
    return (
        <div className="relative group">
            {selected && (
                <div className="absolute top-2 left-2 z-10 bg-primary text-primary-foreground p-1 rounded-full text-xs">
                    ✓
                </div>
            )}
            <button
                type="button"
                onClick={() => onToggle(image)}
                className="w-full rounded-md overflow-hidden relative"
                aria-label={selectLabel}
                title={selectLabel}
            >
                <OptimizedImage
                    src={image.path}
                    alt={image.name ?? `Image ${image.id}`}
                    ratio={1}
                    className="cursor-pointer rounded-md overflow-hidden"
                    imageClassName={`border transition-transform object-contain group-hover:scale-[1.02] ${selected ? "ring-2 ring-primary" : ""}`}
                    loadingIndicator
                />
                <div className="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-colors" />
            </button>
        </div>
    );
}, (prev, next) => prev.selected === next.selected && prev.image.id === next.image.id && prev.image.path === next.image.path);

function ImageGrid({
    isLoading,
    images,
    selectedSet,
    onToggle,
    onEmptyUploadClick,
    t,
}: {
    isLoading: boolean;
    images: ImageItem[];
    selectedSet: Set<string | number>;
    onToggle: (img: ImageItem) => void;
    onEmptyUploadClick: () => void;
    t: StudioImagesTexts;
}) {
    if (isLoading) {
        return (
            <div className="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-2 p-2">
                {Array.from({ length: 12 }).map((_, i) => (
                    <div key={i} className="w-full aspect-square rounded-md overflow-hidden border bg-muted/30 animate-pulse" />
                ))}
            </div>
        );
    }

    if (!images.length) {
        return (
            <div className="p-6 h-full flex flex-col items-center justify-center text-center gap-3">
                <svg width="48" height="48" viewBox="0 0 24 24" className="text-muted-foreground">
                    <path fill="currentColor" d="M20 5H4a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2m0 12H4V7h16v10M8.5 11A1.5 1.5 0 1 0 7 9.5A1.5 1.5 0 0 0 8.5 11M5 17l3.5-4.5l2.5 3l3.5-4.5L19 17H5Z" />
                </svg>
                <div className="text-lg font-medium">{t.emptyTitle}</div>
                <p className="text-sm text-muted-foreground">{t.emptyDescription}</p>
                <Button onClick={onEmptyUploadClick}>{t.emptyAction}</Button>
            </div>
        );
    }

    return (
        <div className="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-2 p-2">
            {images.map((img) => (
                <ImageCard
                    key={img.id}
                    image={img}
                    selected={selectedSet.has(img.id)}
                    onToggle={onToggle}
                    selectLabel={t.selectImage}
                />
            ))}
        </div>
    );
}

function UploadSection({
    isMulti,
    uploading,
    uploadError,
    uploadSuccessCount,
    onFiles,
    dragOver,
    setDragOver,
    t,
}: {
    isMulti: boolean;
    uploading: boolean;
    uploadError: string | null;
    uploadSuccessCount: number;
    onFiles: (files: File[]) => void;
    dragOver: boolean;
    setDragOver: (v: boolean) => void;
    t: StudioImagesTexts;
}) {
    const inputRef = useRef<HTMLInputElement | null>(null);

    const onDrop = useCallback(
        (e: React.DragEvent<HTMLDivElement>) => {
            e.preventDefault();
            e.stopPropagation();
            setDragOver(false);
            const files = Array.from(e.dataTransfer.files ?? []).filter((f) => f.type.startsWith("image/"));
            if (files.length) onFiles(files);
        },
        [onFiles, setDragOver]
    );

    const onSelect = useCallback(
        (e: React.ChangeEvent<HTMLInputElement>) => {
            const files = Array.from(e.target.files ?? []);
            if (files.length) onFiles(files);
            // reset so same files can be selected again
            e.target.value = "";
        },
        [onFiles]
    );

    return (
        <div className="flex flex-col gap-4 max-h-[75vh]">
            <label className="text-sm" htmlFor="studio-upload-input">اختر ملفات للرفع</label>
            <input
                ref={inputRef}
                type="file"
                accept="image/*"
                multiple={isMulti}
                id="studio-upload-input"
                aria-label="اختيار ملفات صور"
                title="اختيار ملفات صور"
                onChange={onSelect}
                className="hidden"
            />
            <div
                onDragOver={(e) => {
                    e.preventDefault();
                    setDragOver(true);
                }}
                onDragLeave={() => setDragOver(false)}
                onDrop={onDrop}
                className={`border-2 border-dashed rounded-md p-6 text-center cursor-pointer transition-colors ${dragOver ? "border-primary bg-primary/5" : "border-muted-foreground/30"}`}
                onClick={() => inputRef.current?.click()}
            >
                <div className="text-sm mb-2">اسحب وأفلت الصور هنا أو انقر للاختيار</div>
                <div className="text-xs text-muted-foreground">PNG, JPG, GIF</div>
            </div>

            {uploading && (
                <div className="flex items-center gap-3">
                    <div className="w-full h-2 rounded bg-muted overflow-hidden">
                        <div className="h-full w-1/2 bg-primary animate-pulse" />
                    </div>
                    <div className="text-sm">{t.uploading}</div>
                </div>
            )}
            {!uploading && uploadSuccessCount > 0 && (
                <div className="text-sm text-green-600">{t.uploadSuccess(uploadSuccessCount)}</div>
            )}
            {!uploading && uploadError && (
                <div className="text-sm text-red-600">{uploadError}</div>
            )}
        </div>
    );
}

// -------------------- Main Component --------------------
export default function StudioImages({
    isOpen,
    onClose,
    fetchImages,
    onImageSelect,
    onImageUpload,
    isMulti = false,
    maxSelectable,
    texts,
}: StudioImagesProps) {
    const t = { ...defaultTexts, ...texts };

    const { state, dispatch, loadImages, toggleSelect, handleFiles, filteredImages, selectedImages } =
        useStudioImages(isMulti, fetchImages, onImageUpload, maxSelectable);

    // Auto-load when dialog opens
    useEffect(() => {
        if (isOpen) {
            loadImages();
        }
    }, [isOpen, loadImages]);

    const handleToggle = useCallback(
        (img: ImageItem) => {
            // enforce maxSelectable with basic UX feedback (no toast here to stay self‑contained)
            if (isMulti && maxSelectable && !state.selected.has(img.id) && state.selected.size >= maxSelectable) {
                // silently ignore; optionally, you may integrate your toast system here
                return;
            }
            toggleSelect(img.id);
        },
        [isMulti, maxSelectable, state.selected, toggleSelect]
    );

    const handleConfirm = useCallback(async () => {
        if (selectedImages.length === 0) return;
        dispatch({ type: "ASSIGN_START" });
        try {
            await onImageSelect(isMulti ? selectedImages : selectedImages[0]);
            onClose();
        } finally {
            dispatch({ type: "ASSIGN_END" });
        }
    }, [dispatch, isMulti, onClose, onImageSelect, selectedImages]);

    return (
        <Dialog open={isOpen} onOpenChange={onClose}>
            <DialogContent className="min-w-[95%] h-[95%]">
                <DialogHeader className="p-0 m-0 h-fit">
                    <DialogTitle>{t.title}</DialogTitle>
                    <DialogDescription className="text-center text-gray-500">
                        {t.subtitle}
                    </DialogDescription>
                </DialogHeader>

                <div className="grid grid-rows-[2.5rem_1fr] gap-2 min-h-[80vh]">
                    <Toolbar
                        activeTab={state.activeTab}
                        setTab={(tab) => dispatch({ type: "SET_TAB", tab })}
                        refresh={loadImages}
                        isLoading={state.isLoading}
                        search={state.search}
                        setSearch={(v) => dispatch({ type: "SET_SEARCH", search: v })}
                        t={t}
                    />

                    {state.activeTab === "view" ? (
                        <div className="grid grid-rows-[1fr_2.5rem] gap-2 max-h-[75vh]">
                            <div className="w-full scrollbar max-h-[70vh] border p-1 rounded-md">
                                {state.error ? (
                                    <div className="flex flex-col items-center gap-2 p-4">
                                        <p className="text-gray-500">{state.error}</p>
                                        <Button variant="outline" onClick={loadImages}>{t.refresh}</Button>
                                    </div>
                                ) : (
                                    <ImageGrid
                                        isLoading={state.isLoading}
                                        images={filteredImages}
                                        selectedSet={state.selected}
                                        onToggle={handleToggle}
                                        onEmptyUploadClick={() => dispatch({ type: "SET_TAB", tab: "upload" })}
                                        t={t}
                                    />
                                )}
                            </div>
                            <DialogFooter>
                                <Button
                                    variant="outline"
                                    onClick={handleConfirm}
                                    disabled={selectedImages.length === 0 || state.assignLoading}
                                >
                                    {isMulti
                                        ? `${t.assignImage} (${selectedImages.length})`
                                        : t.assignImage}
                                </Button>
                            </DialogFooter>
                        </div>
                    ) : (
                        <UploadSection
                            isMulti={isMulti}
                            uploading={state.uploading}
                            uploadError={state.uploadError}
                            uploadSuccessCount={state.uploadSuccessCount}
                            onFiles={handleFiles}
                            dragOver={state.dragOver}
                            setDragOver={(v) => dispatch({ type: "SET_DRAG_OVER", value: v })}
                            t={t}
                        />
                    )}
                </div>
            </DialogContent>
        </Dialog>
    );
}
