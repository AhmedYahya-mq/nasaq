import { TableCell } from "@/components/ui/table";
import { CellContext } from "@tanstack/react-table";

export const centeredTextCell = ({ getValue }: any) => {
    const v = getValue(); 
    return <TableCell className="text-center">{v ?? ""}</TableCell>;
};
