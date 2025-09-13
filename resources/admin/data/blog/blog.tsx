import { ExtendedColumnDef } from "@/types";
import { Membership } from "@/types/model/membership.d";
import { actionsCell, textCell, booleanBadgeCell, sarCurrencyCell, descriptionCell, centeredTextCell } from "../../lib/tableHelpers";

interface MembershipActions {
    onEdit: (item: Membership) => void;
    onDelete: (item: Membership) => void;
    onTranslate: (item: Membership) => void;
}

export const getColumns = ({ onEdit, onDelete, onTranslate }: MembershipActions): ExtendedColumnDef<Membership>[] => [
    {
        accessorKey: "id", header: "ID",
        cell: centeredTextCell
    },
    {
        accessorKey: "name", header: "اسم العضوية",
        cell: textCell
    },
    {
        accessorKey: "description", header: "الوصف",
        cell: descriptionCell
    },
    {
        accessorKey: "price", header: "السعر (ر.س)",
        cell: sarCurrencyCell()
    },
    {
        accessorKey: "discounted_price",
        header: "السعر بعد الخصم (ر.س)",
        cell: sarCurrencyCell()
    },
    {
        accessorKey: "is_active",
        header: "الحالة",
        cell: booleanBadgeCell("نشطة", "غير نشطة"),
    },
    {
        accessorKey: "duration_days",
        header: "المدة (يوم)",
        cell: centeredTextCell
    },
    {
        header: "Actions", accessorKey: "actions", nonHideable: true,
        cell: actionsCell(onEdit, onDelete, onTranslate)
    },
];
