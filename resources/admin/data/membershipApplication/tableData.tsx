import { MembershipApplication } from "@/types/membershipApplication";
import { applicationStatusOptions, canResubmitOptions, paymentStatusOptions } from "./tableOptions";
import { ExtendedColumnDef } from "@/types";
import { TableCell } from "@/components/ui/table";
import { actionsCell, booleanBadgeCell, dateCell, textCell } from "../tableHelpers";
import { Badge } from "@/components/ui/badge";

export const applications: MembershipApplication[] = Array.from(
    { length: 2000 },
    (_, i) => ({
        id: i + 1,
        userId: 1000 + i,
        membershipId: (i % 5) + 1,
        formData: { field1: "قيمة تجريبية " + (i + 1) },
        amount: Math.floor(Math.random() * 100) + 20,
        // استخدام options
        paymentStatus: paymentStatusOptions[i % paymentStatusOptions.length].value as
            | "Pending"
            | "Paid"
            | "Failed",
        applicationStatus: applicationStatusOptions[i % applicationStatusOptions.length].value as
            | "Pending"
            | "Approved"
            | "Rejected",
        canResubmit: canResubmitOptions[i % canResubmitOptions.length].value === "true",
        createdAt: new Date().toISOString(),
        updatedAt: new Date().toISOString(),
    })
);

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
        cell: actionsCell, nonHideable: true
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

