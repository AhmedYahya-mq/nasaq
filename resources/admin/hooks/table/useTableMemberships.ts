import { columns } from './../../data/membershipApplication/tableData';
import { useState, useMemo, useEffect, useContext } from "react";
import { Membership } from "@/types/model/membership.d";
import OpenFormContext from "@/context/OpenFormContext";
import { destroy } from "@/routes/admin/membership";
import axios from "axios";
import { toast } from "sonner";
import { getErrorMessage } from "@/lib/utils";
import { getCoreRowModel, getFilteredRowModel, getPaginationRowModel, getSortedRowModel, useReactTable } from "@tanstack/react-table";

/**
 * هوك لإدارة جدول العضويات مع دعم البحث، الإضافة، التعديل، الحذف، والترجمة
 * @param memberships قائمة العضويات الأولية
 * @param handleDelete دالة الحذف التي تستدعى عند حذف عنصر
 * @returns جميع الدوال والحالات اللازمة لإدارة الجدول
 */
export function useTableMemberships({ memberships, handleDelete }: { memberships: Membership[], handleDelete?: (fn: () => Promise<boolean>, targetItem: any) => void }) {
    const [search, setSearch] = useState<string>("");
    const [isClient, setIsClient] = useState(false);
    const [tableData, setTableData] = useState<Membership[]>(memberships);
    const [selectedRow, setSelectedRow] = useState<Membership | null>(null);
    const { openEdit, openTranslate } = useContext(OpenFormContext);
    const [columns, setColumns] = useState<any[]>([]);

    useEffect(() => {
        setIsClient(true);
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
    const deleteRow = (item: Membership) => {
        handleDelete?.(async () => {
            let isSuccess = false;
            await axios.delete(destroy(item.id).url).then(() => {
                setTableData(prev => prev.filter(row => row.id !== item.id));
                toast.success(`تم حذف عضوية ${item.name} بنجاح`);
                isSuccess = true;
            }).catch((error) => {
                toast.error(getErrorMessage(error.status, `العضوية ${item.name}`))
            });
            return isSuccess;
        }, item);
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
