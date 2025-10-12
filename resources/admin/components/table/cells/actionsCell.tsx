import { TableCell } from "@/components/ui/table";
import { EditIcon, Trash2Icon, GlobeIcon, EyeIcon, DownloadIcon } from "lucide-react";
import { Tooltip, TooltipContent, TooltipTrigger } from "@/components/ui/tooltip";

type ActionHandlers = {
    onEdit?: (item: any) => void;
    onDelete?: (item: any) => void;
    onTranslate?: (item: any) => void;
    onView?: (item: any) => void;
    onDownload?: (item: any) => void;
};

const actionMap = {
    onEdit: { Icon: EditIcon, color: "text-blue-600", label: "تعديل" },
    onDelete: { Icon: Trash2Icon, color: "text-red-600", label: "حذف" },
    onTranslate: { Icon: GlobeIcon, color: "text-green-600", label: "ترجمة" },
    onView: { Icon: EyeIcon, color: "text-gray-600", label: "عرض" },
    onDownload: { Icon: DownloadIcon, color: "text-primary", label: "تنزيل" },
};

export const actionsCell =
    (handlers: ActionHandlers = {}) =>
        ({ row }: any) => {
            const item = row.original;

            return (
                <TableCell className="text-center">
                    <div className="flex items-center justify-center space-x-4">
                        {Object.entries(handlers).map(([key, fn]) => {
                            if (!fn) return null;
                            const { Icon, color, label } = actionMap[key as keyof ActionHandlers];
                            return (
                                <Tooltip key={key}>
                                    <TooltipTrigger asChild className="!cursor-pointer">
                                        <Icon
                                            size={16}
                                            className={`!cursor-pointer ${color}`}
                                            onClick={() => fn(item)}
                                        />
                                    </TooltipTrigger>
                                    <TooltipContent className="text-white">
                                        <p>{label}</p>
                                    </TooltipContent>
                                </Tooltip>
                            );
                        })}
                    </div>
                </TableCell>
            );
        };
