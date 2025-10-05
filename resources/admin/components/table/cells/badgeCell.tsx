import { TableCell } from "@/components/ui/table";
import { Badge } from "@/components/ui/badge";

export const badgeCell = ({ getValue }: any) => {
    const { label_ar, color } = getValue() || { label_ar: "-", color: "gray" };
    return (
        <TableCell className="text-center">
            <Badge
                style={{
                    backgroundColor: color,
                    color: "white",
                }}
            >
                {label_ar}
            </Badge>
        </TableCell>
    );
};
