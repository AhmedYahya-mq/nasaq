import { ExtendedColumnDef } from "@/types";
import { Membership } from "@/types/membership";
import { actionsCell, textCell } from "../tableHelpers";

// إنشاء بيانات وهمية
export const memberships: Membership[] = Array.from({ length: 2000 }, (_, i) => ({
    id: i + 1,
    name: `Membership ${i + 1}`,
    description: `وصف العضوية رقم ${i + 1}`,
    price: Math.floor(Math.random() * 100) + 10, // سعر بين 10 و 109
}));


export const columns: ExtendedColumnDef<Membership>[] = [
    {
        accessorKey: "id", header: "ID",
        cell: textCell
    },
    {
        accessorKey: "name", header: "اسم العضوية",
        cell: textCell
    },
    {
        accessorKey: "description", header: "الوصف",
        cell: textCell
    },
    {
        accessorKey: "price", header: "السعر ($)",
        cell: textCell
    },
    {
        header: "Actions", accessorKey: "actions", nonHideable: true,
        cell: actionsCell
    },
];

