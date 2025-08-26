import React, { JSX } from "react";
import { Badge } from "@/components/ui/badge";
import { TableCell } from "@/components/ui/table";
import { Trash2Icon, EditIcon } from "lucide-react";
import { RowsMembershipProps } from "@/types/membership";

const styleBadge: Record<string, string> = {
    delivered: "bg-green-600/25 text-green-500",
    pending: "bg-yellow-600/25 text-yellow-500",
    failed: "bg-red-600/25 text-red-500",
    shipped: "bg-blue-600/25 text-blue-500",
    "out for delivery": "bg-purple-600/25 text-purple-500",
};



export default function MembershipRow({ row, accessorKey }: RowsMembershipProps): JSX.Element {
    return (
        <>
            {{
                "orderId": <TableCell className="text-center">{row.orderId}</TableCell>,
                "date": <TableCell className="text-center">{row.date}</TableCell>,
                "customer": <TableCell className="text-center">{row.customer?.name}</TableCell>,
                "installment": (
                    <TableCell className="text-center">
                        {row.installment}
                    </TableCell>
                ),
                "status": (
                    <TableCell className="text-center">
                        <Badge className={styleBadge[row.status] || ""}>{row.status}</Badge>
                    </TableCell>
                ),
                "paymentMethod": <TableCell className="text-center">{row.paymentMethod}</TableCell>,
                "actions": (
                    <TableCell className="text-center">
                        <div className="flex items-center justify-center space-x-4">
                            <EditIcon size={16} className="cursor-pointer" />
                            <Trash2Icon size={16} className="cursor-pointer text-red-600" />
                        </div>
                    </TableCell>
                ),
            }[accessorKey] || <TableCell className="text-center">{row[accessorKey]}</TableCell>}
        </>
    );
}
