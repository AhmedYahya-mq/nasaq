import React from "react";
import { Dialog, DialogContent, DialogHeader, DialogTitle } from "@/components/ui/dialog";
import { formatDate, isIsoDate } from "@/lib/utils";
import { ColumnLabels } from "@/types";

interface DialogComponenetProps {
    selectedRow: Record<string, any> | null;
    setSelectedRow: (v: Record<string, any> | null) => void;
    columnLabels?: Record<string, ColumnLabels>;
}

export default function DialogComponenet({
    selectedRow,
    setSelectedRow,
    columnLabels = {},
}: DialogComponenetProps): React.JSX.Element {
    return (
        <Dialog  open={!!selectedRow} onOpenChange={() => setSelectedRow(null)}>
            <DialogContent className="@container">
                <DialogHeader>
                    <DialogTitle>تفاصيل</DialogTitle>
                </DialogHeader>

                <div className="max-h-[70vh] scrollbar hover:!overflow-y-auto !overflow-hidden p-2">
                    {selectedRow ? (
                        <div className="mt-4 flex flex-col gap-4">
                            <div className="grid grid-cols-1 gap-4 @sm:grid-cols-2">
                                {Object.entries(selectedRow).map(([key, value]) => {
                                    const colConfig = columnLabels[key] || {};
                                    if (colConfig.hidden) return null;
                                    return (
                                        <div key={key} className="flex flex-col">
                                            <span className="font-medium badget-foreground px-1 rounded-sm">
                                                {colConfig.label || key}
                                            </span>

                                            {/* القيمة */}
                                            <span className="mt-2 text-[0.9em] text-muted-foreground px-2">
                                                {colConfig.prefix && !(value === null || value === undefined) &&(
                                                    <span className="me-1 inline-block">
                                                        {colConfig.prefix}
                                                    </span>
                                                )}
                                                {colConfig.render
                                                    ? colConfig.render(value)
                                                    :
                                                    Array.isArray(value)
                                                        ? arrayHandler(value)
                                                        : value === null || value === undefined
                                                            ? (<span className="px-2 py-1 rounded-md badget-red-500">غير معرف</span>)
                                                            : isIsoDate(value)
                                                                ? formatDate(value)
                                                                : String(value)}
                                                {colConfig.suffix && !(value === null || value === undefined) && (
                                                    <span className="ms-1 inline-block">
                                                        {colConfig.suffix}
                                                    </span>
                                                )}
                                            </span>
                                        </div>
                                    );
                                })}
                            </div>
                        </div>
                    ) : (
                        <p>لا توجد بيانات لعرضها.</p>
                    )}
                </div>
            </DialogContent>
        </Dialog>
    );
}

function arrayHandler(arr: any[]) {
    return (
        <div className="flex flex-wrap gap-2">
            {arr.map((item, index) => (
                <div key={index} className="badget px-2 rounded-full">
                    {String(item)}
                </div>
            ))}
        </div>
    );
}
