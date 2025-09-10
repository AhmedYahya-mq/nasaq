import { TableCell } from "@/components/ui/table";
import { Badge } from "@/components/ui/badge";
import { EditIcon, Trash2Icon } from "lucide-react";

export const textCell = ({ getValue }: any) => (
    <TableCell className="text-center">{getValue()}</TableCell>
);


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
    const date = new Date(getValue());
    return <TableCell className="text-center">{date.toLocaleDateString()} {date.toLocaleTimeString()}</TableCell>;
};

export const actionsCell = () => (
    <TableCell className="text-center" >
        <div className="flex items-center justify-center space-x-4" >
            <EditIcon size={16} className="cursor-pointer" />
            <Trash2Icon size={16} className="cursor-pointer text-red-600" />
        </div>
    </TableCell>
);
