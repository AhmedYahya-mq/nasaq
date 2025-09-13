import { TableCell } from "@/components/ui/table";
import { Badge } from "@/components/ui/badge";
import { EditIcon, Trash2Icon } from "lucide-react";
import IconRial from "@/components/icon-rial";
import { GlobeIcon } from "lucide-react"; // Added for translation button
import { Tooltip, TooltipContent, TooltipTrigger } from "@/components/ui/tooltip";
import { formatterNumber } from "./utils";

export const textCell = ({ getValue }: any) => {
    const v = getValue?.();
    return <TableCell className="">{v ?? ""}</TableCell>;
};

export const centeredTextCell = ({ getValue }: any) => {
    const v = getValue?.();
    return <TableCell className="text-center">{v ?? ""}</TableCell>;
};

export const descriptionCell = ({ getValue }: any) => {
    const v = getValue?.();
    return <TableCell>
        <span className="max-w-xs line-clamp-2 break-words whitespace-normal">{v ?? ""}</span>
    </TableCell>;
}


export const booleanBadgeCell = (trueLabel = "نعم", falseLabel = "لا") => ({ getValue }: any) => {
    const value = getValue();
    return (
        <TableCell className="text-center">
            <Badge className={value ? "bg-green-600/25 text-green-500" : "bg-red-600/25 text-red-500"}>
                {value ? trueLabel : falseLabel}
            </Badge>
        </TableCell>
    );
};

export const dateCell = ({ getValue }: any) => {
    const raw = getValue?.();
    if (!raw) return <TableCell className="text-center">-</TableCell>;
    const date = new Date(raw);
    if (isNaN(date.getTime())) return <TableCell className="text-center">-</TableCell>;
    return (
        <TableCell className="text-center">
            {date.toLocaleDateString()} {date.toLocaleTimeString()}
        </TableCell>
    );
};

export const currencyCell = (locale = "ar-EG", currency = "USD") => ({ getValue }: any) => {
    const raw = getValue?.() as number | string | null | undefined;
    if (raw === null || raw === undefined || raw === "") {
        return <TableCell className="text-center">-</TableCell>;
    }
    return <TableCell className="text-center">{formatterNumber(raw)}</TableCell>;
};

export const listCell = (separator = ", ") => ({ getValue }: any) => {
    const v = getValue?.();
    const arr = Array.isArray(v) ? v : [];
    return <TableCell className="text-center">{arr.join(separator)}</TableCell>;
};

export const actionsCell = (onEdit?: (item: any) => void, onDelete?: (item: any) => void, onTranslate?: (item: any) => void) => ({ row }: any) => {
    const item = row.original;
    return (
        <TableCell className="text-center" >
            <div className="flex items-center justify-center space-x-4" >
                {onEdit &&
                    <Tooltip>
                        <TooltipTrigger>
                            <EditIcon size={16} className="cursor-pointer text-blue-600" onClick={() => onEdit(item)} />
                        </TooltipTrigger>
                        <TooltipContent>
                            <p>تعديل</p>
                        </TooltipContent>
                    </Tooltip>
                }
                {onTranslate &&
                    <Tooltip>
                        <TooltipTrigger>
                            <GlobeIcon size={16} className="cursor-pointer text-green-600" onClick={() => onTranslate(item)} />
                        </TooltipTrigger>
                        <TooltipContent>
                            <p>ترجمة</p>
                        </TooltipContent>
                    </Tooltip>
                }
                {onDelete &&
                    <Tooltip>
                        <TooltipTrigger>
                            <Trash2Icon size={16} className="cursor-pointer text-red-600" onClick={() => onDelete(item)} />
                        </TooltipTrigger>
                        <TooltipContent>
                            <p>حذف</p>
                        </TooltipContent>
                    </Tooltip>
                }
            </div>
        </TableCell>
    );
};


// Saudi Riyal currency cell with icon
export const sarCurrencyCell = () => ({ getValue }: any) => {
    const raw = getValue?.() as number | string | null | undefined;
    if (raw === null || raw === undefined || raw === "") {
        return <TableCell className="text-center">-</TableCell>;
    }
    const num = typeof raw === "string" ? Number(raw) : raw;
    if (!Number.isFinite(num)) {
        return <TableCell className="text-center">{String(raw)}</TableCell>;
    }



    const valueOnly = formatterNumber(num);
    return (
        <TableCell className="text-center">
            <div className="flex items-center justify-center flex-row-reverse" >
                <IconRial className="size-4 *:fill-primary" />
                {valueOnly}
            </div>
        </TableCell>
    );
};
