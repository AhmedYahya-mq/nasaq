
import { useState, useMemo, useEffect, useContext } from "react";
import OpenFormContext from "@/context/OpenFormContext";
import axios from "axios";
import { toast } from "sonner";
import { getErrorMessage } from "@/lib/utils";
import { getCoreRowModel, getFilteredRowModel, getPaginationRowModel, getSortedRowModel, useReactTable } from "@tanstack/react-table";

import { ExtendedColumnDef, ButtonsActions } from "@/types";
import { confirmAlertDialog } from "@/components/custom/ConfirmDialog";
import { actionsCell, badgeCell, centeredTextCell, dateCell, descriptionCell, SwitchCell, textCell } from "@/components/table";
import { Members } from "@/types/model/members";
import { block, destroy, show } from "@/routes/admin/members";
import { router } from '@inertiajs/react';

// هوك لإدارة جدول الأعضاء مع دعم البحث، الإضافة، التعديل، الحذف، والترجمة
export function useTableMembers({ members }: { members: Members[] }) {
    const [search, setSearch] = useState<string>("");
    const [isClient, setIsClient] = useState(false);
    const [tableData, setTableData] = useState<Members[]>(members);
    const [selectedRow, setSelectedRow] = useState<Members | null>(null);
    const { openEdit } = useContext(OpenFormContext);
    const [columns, setColumns] = useState<any[]>([]);

    useEffect(() => {
        setIsClient(true);
        setColumns(getColumns({ onEdit: editRow, onDelete: deleteRow, onView: viewMember, onChange: toggleBlockMember }));
    }, []);

    // تصفية البيانات بناءً على نص البحث
    const filteredData = useMemo(() => {
        return tableData.filter((item) => {
            return (!search || Object.values(item).some((val) => String(val).toLowerCase().includes(search.toLowerCase())));
        });
    }, [tableData, search]);

    // إضافة صف جديد للجدول
    const addRow = (member: Members) => {
        setTableData(prev => [member, ...prev]);
        toast.success(`تم إضافة العضو ${member.name} بنجاح`);
    };

    // تحديث بيانات صف موجود في الجدول
    const updateRow = (member: Members, isTranslate: boolean) => {
        setTableData(prev =>
            prev.map(row => (row.id === member.id ? member : row))
        );
        if (isTranslate) {
            toast.success(`تمت ترجمة العضو ${member?.name} بنجاح`);
            return;
        }
        toast.success(`تم تحديث العضو ${member.name} بنجاح`);
    };

    // استدعاء نافذة التأكيد لحذف صف
    const deleteRow = async (item: Members) => {
        const ok = await confirmAlertDialog({
            title: "هل أنت متأكد؟",
            description: `سيتم حذف العضو ${item.name} نهائيًا.`
        });
        if (!ok) return;
        const toastId = toast.loading(`جاري حذف العضو ${item.name}...`);
        let isSuccess = false;
        await axios.delete(destroy(item.id).url).then(() => {
            setTableData(prev => prev.filter(row => row.id !== item.id));
            toast.success(`تم حذف العضو ${item.name} بنجاح`);
            isSuccess = true;
        }).catch((error) => {
            toast.error(getErrorMessage(error.status, `العضو ${item.name}`))
        }).finally(() => {
            toast.dismiss(toastId);
        });
        return isSuccess;
    };

    const toggleBlockMember = async (item: Members): Promise<boolean> => {
        const action = item.is_active ? "حظر" : "فك الحظر";
        const ok = await confirmAlertDialog({
            title: "هل أنت متأكد؟",
            description: `سيتم ${action} العضو ${item.name} ${item.is_active ? "ولن يتمكن من تسجيل الدخول." : "وسيتمكن من تسجيل الدخول."}`
        });
        if (!ok) return item.is_active;

        const toastId = toast.loading(`جاري ${action} العضو ${item.name}...`);
        let updated: Members | null = null;

        try {
            const response = await axios.put(block(item.id).url);
            updated = response.data.member;

            setTableData(prev =>
                prev.map(row => (row.id === item.id ? updated! : row))
            );

            toast.success(`تم ${action} العضو ${item.name} بنجاح`);
        } catch (error: any) {
            toast.error(getErrorMessage(error.status, `العضو ${item.name}`));
        } finally {
            toast.dismiss(toastId);
        }

        return updated?.is_active ?? false;
    };


    // فتح نافذة التعديل لصف محدد
    const editRow = (item: Members) => {
        openEdit?.(item);
    };

    // فتح نافذة الترجمة لصف محدد
    const viewMember = (item: Members) => {
        router.visit(show(item.id).url);
    };

    const table = useReactTable({
        data: tableData,
        columns,
        getCoreRowModel: getCoreRowModel(),
        getSortedRowModel: getSortedRowModel(),
        getFilteredRowModel: getFilteredRowModel(),
        getPaginationRowModel: getPaginationRowModel(),
        initialState: { pagination: { pageSize: 10 } },
    });

    return {
        isClient,
        table,
        columns,
        search,
        tableData: filteredData,
        selectedRow,
        setColumns,
        setSearch,
        setSelectedRow,
        addRow,
        updateRow,
    };
}

// نفس أعمدة الجدول في tableData.tsx
const getColumns = ({ onEdit, onDelete, onView, onChange }: ButtonsActions): ExtendedColumnDef<Members>[] => [
  {
    accessorKey: "id",
    header: "ID",
    cell: centeredTextCell,
  },
  {
    accessorKey: "name",
    header: "الاسم",
    cell: textCell,
  },
  {
    accessorKey: "email",
    header: "البريد الإلكتروني",
    cell: textCell,
    nonHideable: true,
  },
  {
    accessorKey: "phone",
    header: "رقم الجوال",
    cell: textCell,
  },
  {
    accessorKey: "membership_name",
    header: "نوع العضوية",
    cell: textCell,
  },
  {
    accessorKey: "membership_status",
    header: "حالة العضوية",
    cell: badgeCell,
  },
  {
    accessorKey: "membership_expires_at",
    header: "تاريخ انتهاء",
    cell: dateCell(false),
  },
  {
    accessorKey: "is_active",
    header: "الحالة",
    cell: SwitchCell(onChange as (item: Members) => Promise<boolean>),
    nonHideable: true,
  },
  {
    accessorKey: "actions",
    header: "Actions",
    cell: actionsCell({ onEdit, onDelete, onView }),
    nonHideable: true,
  }
];

