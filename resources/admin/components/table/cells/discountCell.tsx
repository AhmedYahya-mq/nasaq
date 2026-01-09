import { TableCell } from "@/components/ui/table";

export const discountCell = (value: CouponModel["value"], row: CouponModel) => {
    const v = row.discount_type === 'percent' ? `${value}%` : `${value}`;
    return <TableCell className="text-center">{v ?? ""}</TableCell>;
};
