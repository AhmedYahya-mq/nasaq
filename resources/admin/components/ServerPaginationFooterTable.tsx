import { Button } from "@/components/ui/button";
import { Label } from "@/components/ui/label";
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/components/ui/select";
import { Links } from "@/types";
import {
    ChevronLeft,
    ChevronRight,
    ChevronsLeft,
    ChevronsRight,
} from "lucide-react";

interface ServerPaginationFooterProps {
    pagination: {
        links: Links;
        meta: Meta;
    };
    onPageChange: (url: string | null) => void;
    onPageSizeChange?: (size: number, path: string) => void;
}

export default function ServerPaginationFooterTable({
    pagination,
    onPageChange,
    onPageSizeChange,
}: ServerPaginationFooterProps) {
    const { links, meta } = pagination;

    const handleFirst = () => {
        const firstLink = links.first;
        onPageChange(firstLink ?? null);
    };

    const handleLast = () => {
        const lastLink = links.last;
        onPageChange(lastLink ?? null);
    };

    const handlePrevious = () => {
        const prevLink = links.prev;
        onPageChange(prevLink ?? null);
    };

    const handleNext = () => {
        const nextLink = links.next;
        onPageChange(nextLink ?? null);
    };
    console.log(pagination);
    
    return (
        <div className="flex items-center justify-between px-4">
            <div className="text-muted-foreground hidden flex-1 text-sm lg:flex">
                {meta.per_page * (meta.current_page - 1) + 1} -{" "}
                {Math.min(meta.per_page * meta.current_page, meta.total)} من {meta.total} صفوف
            </div>

            <div className="flex w-full items-center gap-8 lg:w-fit">
                {onPageSizeChange && (
                    <div className="hidden items-center gap-2 lg:flex">
                        <Label htmlFor="rows-per-page" className="text-sm font-medium">
                            الصفوف لكل صفحة
                        </Label>
                        <Select
                            value={`${meta.per_page}`}
                            onValueChange={(value) => onPageSizeChange(Number(value), meta.path)}
                        >
                            <SelectTrigger className="w-20" id="rows-per-page">
                                <SelectValue placeholder={meta.per_page.toString()} />
                            </SelectTrigger>
                            <SelectContent side="top">
                                {[10, 20, 30, 40, 50].map((size) => (
                                    <SelectItem key={size} value={`${size}`}>
                                        {size}
                                    </SelectItem>
                                ))}
                            </SelectContent>
                        </Select>
                    </div>
                )}

                <div className="flex w-fit items-center justify-center text-sm font-medium">
                    الصفحة {meta.current_page} من {meta.last_page}
                </div>

                <div className="ml-auto flex rtl:flex-row-reverse items-center gap-2 lg:ml-0 rtl:rtl">
                    <Button variant="outline" size="icon" onClick={handleFirst} disabled={meta.current_page === 1}>
                        <span className="sr-only">الانتقال إلى الصفحة الأولى</span>
                        <ChevronsLeft />
                    </Button>
                    <Button variant="outline" size="icon" onClick={handlePrevious} disabled={!links.prev}>
                        <span className="sr-only">الانتقال إلى الصفحة السابقة</span>
                        <ChevronLeft />
                    </Button>
                    <Button variant="outline" size="icon" onClick={handleNext} disabled={!links.next}>
                        <span className="sr-only">الانتقال إلى الصفحة التالية</span>
                        <ChevronRight />
                    </Button>
                    <Button variant="outline" size="icon" onClick={handleLast} disabled={meta.current_page === meta.last_page}>
                        <span className="sr-only">الانتقال إلى الصفحة الأخيرة</span>
                        <ChevronsRight />
                    </Button>
                </div>
            </div>
        </div>
    );
}
