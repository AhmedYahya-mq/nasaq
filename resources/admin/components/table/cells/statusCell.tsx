import { TableCell } from "@/components/ui/table";

export const statusCell = (value: CouponModel["status"]) => (
    value ? <TableCell className="text-center">
        <span className="inline-flex items-center justify-center gap-1 rounded-full px-2 py-1 text-xs" style={{ backgroundColor: value.color, color: "#fff" }}>{value.label_ar}</span>
    </TableCell> : '-'
);
