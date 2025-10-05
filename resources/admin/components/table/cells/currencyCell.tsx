import { TableCell } from "@/components/ui/table";
import { formatterNumber } from "@/lib/utils";

export const currencyCell = (locale = "ar-EG", currency = "USD") => ({ getValue }: any) => {
    const raw = getValue?.() as number | string | null | undefined;
    if (raw === null || raw === undefined || raw === "") {
        return <TableCell className="text-center">-</TableCell>;
    }
    return <TableCell className="text-center">{formatterNumber(raw)}</TableCell>;
};
