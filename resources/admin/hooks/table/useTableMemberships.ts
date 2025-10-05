import { useState, useMemo, useEffect, useContext } from "react";
import { Membership } from "@/types/model/membership.d";
import OpenFormContext from "@/context/OpenFormContext";
import { destroy } from "@/routes/admin/membership";
import axios from "axios";
import { toast } from "sonner";
import { getErrorMessage } from "@/lib/utils";
import { getCoreRowModel, getFilteredRowModel, getPaginationRowModel, getSortedRowModel, useReactTable } from "@tanstack/react-table";
import { confirmAlertDialog } from '@/components/custom/ConfirmDialog';
import { ButtonsActions, ExtendedColumnDef } from '@/types';
import { actionsCell, booleanBadgeCell, centeredTextCell, descriptionCell, sarCurrencyCell, SwitchCell, textCell } from "@/components/table";


/**
 * هوك لإدارة جدول العضويات مع دعم البحث، الإضافة، التعديل، الحذف، والترجمة
 * @param memberships قائمة العضويات الأولية
 * @param handleDelete دالة الحذف التي تستدعى عند حذف عنصر
 * @returns جميع الدوال والحالات اللازمة لإدارة الجدول
 */
export function useTableMemberships({ memberships }: { memberships: Membership[] }) {
    const [search, setSearch] = useState<string>("");
    const [isClient, setIsClient] = useState(false);
    const [tableData, setTableData] = useState<Membership[]>(memberships);
    const [selectedRow, setSelectedRow] = useState<Membership | null>(null);
    const { openEdit, openTranslate } = useContext(OpenFormContext);
    const [columns, setColumns] = useState<any[]>([]);

    useEffect(() => {
        setIsClient(true);
        setColumns(getColumns({ onEdit: editRow, onDelete: deleteRow, onTranslate: translateRow }));
    }, []);

    /**
     * تصفية البيانات بناءً على نص البحث
     * @return قائمة العضويات المفلترة
     */
    const filteredData = useMemo(() => {
        return tableData.filter((item) => {
            return (!search || Object.values(item).some((val) => String(val).toLowerCase().includes(search.toLowerCase())));
        });
    }, [tableData, search]);

    /**
     * إضافة صف جديد للجدول
     * @param newMembership العضوية الجديدة
     * @return void
     */
    const addRow = (newMembership: Membership) => {
        setTableData(prev => [newMembership, ...prev]);
        toast.success(`تم إضافة عضوية ${newMembership.name} بنجاح`);
    };


    /**
     * تحديث بيانات صف موجود في الجدول
     * @param updatedMembership العضوية بعد التحديث
     * @return void
     */
    const updateRow = (updatedMembership: Membership, isTranslate: boolean) => {
        setTableData(prev =>
            prev.map(row => (row.id === updatedMembership.id ? updatedMembership : row))
        );
        if (isTranslate) {
            toast.success(`تمت ترجمة العضوية ${updatedMembership?.name} بنجاح`);
            return;
        }
        toast.success(`تم تحديث عضوية ${updatedMembership.name} بنجاح`);
    };

    /**
     * استدعاء نافذة التأكيد لحذف صف
     * @param item العنصر المستهدف للحذف
     * @return void
     */
    const deleteRow = async (item: Membership) => {
        const ok = await confirmAlertDialog({
            title: "هل أنت متأكد؟",
            description: `سيتم حذف العضوية ${item.name} نهائيًا.`
        });
        if (!ok) return;
        const toastId = toast.loading(`جاري حذف عضوية ${item.name}...`);
        let isSuccess = false;
        await axios.delete(destroy(item.id).url).then(() => {
            setTableData(prev => prev.filter(row => row.id !== item.id));
            toast.success(`تم حذف عضوية ${item.name} بنجاح`);
            isSuccess = true;
        }).catch((error) => {
            toast.error(getErrorMessage(error.status, `العضوية ${item.name}`))
        }).finally(() => {
            toast.dismiss(toastId);
        });
        return isSuccess;
    };

    /**
     * فتح نافذة التعديل لصف محدد
     * @param item العنصر المستهدف للتعديل
     * @return void
     */
    const editRow = (item: Membership) => {
        openEdit?.(item);
    };

    /**
     * فتح نافذة الترجمة لصف محدد
     * @param item العنصر المستهدف للترجمة
     * @return void
     */
    const translateRow = (item: Membership) => {
        openTranslate?.(item);
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
        deleteRow,
        editRow,
        translateRow,
    };
}

const getColumns = ({ onEdit, onDelete, onTranslate }: ButtonsActions): ExtendedColumnDef<Membership>[] => [
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
        cell: sarCurrencyCell
    },
    {
        accessorKey: "discounted_price",
        header: "السعر بعد الخصم (ر.س)",
        cell: sarCurrencyCell
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
        header: "Actions",
        id: "actions",
        accessorKey: "actions",
         nonHideable: true,
        cell: actionsCell({onEdit, onDelete, onTranslate})
    },
];
