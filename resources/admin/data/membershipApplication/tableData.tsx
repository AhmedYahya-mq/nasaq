import { MembershipApplication } from "@/types/model/membershipApplication";
import { applicationStatusOptions, canResubmitOptions, paymentStatusOptions } from "./tableOptions";
import { ExtendedColumnDef } from "@/types";
import { TableCell } from "@/components/ui/table";
import { actionsCell, booleanBadgeCell, dateCell, textCell } from "../../lib/tableHelpers";
import { Badge } from "@/components/ui/badge";

// أعمدة الجدول
export const columns: ExtendedColumnDef<MembershipApplication>[] = [
    {
        accessorKey: "id", header: "ID",
        cell: textCell
    },
    {
        accessorKey: "userId", header: "User ID",
        cell: textCell
    },
    {
        accessorKey: "membershipId", header: "Membership ID",
        cell: textCell
    },
    {
        accessorKey: "amount", header: "المبلغ ($)",
        cell: textCell
    },
    {
        accessorKey: "paymentStatus", header: "حالة الدفع",
        cell: renderPaymentStatus()
    },
    {
        accessorKey: "applicationStatus", header: "حالة الطلب",
        cell: renderApplicationStatusBadge()
    },
    {
        accessorKey: "canResubmit",
        header: "إعادة التقديم",
        cell: ({ getValue }) => {
            return booleanBadgeCell()({ getValue });
        }

    },
    {
        accessorKey: "createdAt", header: "تاريخ الإنشاء", cell: dateCell
    },
    {
        header: "Actions", accessorKey: "actions",
        cell: actionsCell(), nonHideable: true
    },
];


function renderApplicationStatusBadge() {
    return ({ getValue }: any) => {
        const value = getValue();
        const option = applicationStatusOptions.find(opt => opt.value === value);
        const label = option ? option.label : value;
        const styleBadge: Record<string, string> = {
            "قيد المراجعة": "bg-yellow-600/25 text-yellow-500",
            "مقبول": "bg-green-600/25 text-green-500",
            "مرفوض": "bg-red-600/25 text-red-500",
        };
        return (
            <TableCell className="text-center">
                <Badge className={styleBadge[label] || "bg-gray-600/25 text-gray-500"}>
                    {label}
                </Badge>
            </TableCell>
        );
    };
}

function renderPaymentStatus() {
    return ({ getValue }: any) => {
        const value = getValue();
        const option = paymentStatusOptions.find(opt => opt.value === value);
        const label = option ? option.label : value;
        const styleBadge: Record<string, string> = {
            "قيد الانتظار": "bg-yellow-600/25 text-yellow-500",
            "مدفوع": "bg-green-600/25 text-green-500",
            "فشل": "bg-red-600/25 text-red-500",
        };
        return (
            <TableCell className="text-center">
                <Badge className={styleBadge[label] || "bg-gray-600/25 text-gray-500"}>
                    {label}
                </Badge>
            </TableCell>
        );
    };
}

export const applications: MembershipApplication[] = [];

