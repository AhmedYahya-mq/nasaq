import { useState, useMemo, useEffect, useContext } from "react";
import OpenFormContext from "@/context/OpenFormContext";
import axios from "axios";
import { toast } from "sonner";
import { getErrorMessage } from "@/lib/utils";
import { getCoreRowModel, getFilteredRowModel, getPaginationRowModel, getSortedRowModel, useReactTable } from "@tanstack/react-table";
import { Blog } from "@/types/model/blogs.d";
import { actionsCell, centeredTextCell, dateCell, descriptionCell, textCell } from "@/lib/tableHelpers";
import { ButtonsActions, ExtendedColumnDef } from "@/types/ui/table/table";
import { destroy } from "@/routes/admin/blogs";

/**
 * هوك لإدارة جدول العضويات مع دعم البحث، الإضافة، التعديل، الحذف، والترجمة
 * @param memberships قائمة العضويات الأولية
 * @param handleDelete دالة الحذف التي تستدعى عند حذف عنصر
 * @returns جميع الدوال والحالات اللازمة لإدارة الجدول
 */
export function useTableBlogs({ blogs, handleDelete }: { blogs: Blog[], handleDelete?: (fn: () => Promise<boolean>, targetItem: any) => void }) {
    const [search, setSearch] = useState<string>("");
    const [isClient, setIsClient] = useState(false);
    const [tableData, setTableData] = useState<Blog[]>(blogs);
    const [selectedRow, setSelectedRow] = useState<Blog | null>(null);
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
     * @param blog العضوية الجديدة
     * @return void
     */
    const addRow = (blog: Blog) => {
        setTableData(prev => [blog, ...prev]);
        toast.success(`تم إضافة عضوية ${blog.title} بنجاح`);
    };

    /**
     * تحديث بيانات صف موجود في الجدول
     * @param blog العضوية بعد التحديث
     * @return void
     */
    const updateRow = (blog: Blog, isTranslate: boolean) => {
        setTableData(prev =>
            prev.map(row => (row.id === blog.id ? blog : row))
        );
        if (isTranslate) {
            toast.success(`تمت ترجمة العضوية ${blog?.title} بنجاح`);
            return;
        }
        toast.success(`تم تحديث عضوية ${blog.title} بنجاح`);
    };

    /**
     * استدعاء نافذة التأكيد لحذف صف
     * @param item العنصر المستهدف للحذف
     * @return void
     */
    const deleteRow = (item: Blog) => {
        handleDelete?.(async () => {
            let isSuccess = false;
            await axios.delete(destroy(item.id).url).then(() => {
                setTableData(prev => prev.filter(row => row.id !== item.id));
                toast.success(`تم حذف ${item.title} بنجاح`);
                isSuccess = true;
            }).catch((error) => {
                toast.error(getErrorMessage(error.status, `المدونة ${item.title}`))
            });
            return isSuccess;
        }, item);
    };

    /**
     * فتح نافذة التعديل لصف محدد
     * @param item العنصر المستهدف للتعديل
     * @return void
     */
    const editRow = (item: Blog) => {
        openEdit?.(item);
    };

    /**
     * فتح نافذة الترجمة لصف محدد
     * @param item العنصر المستهدف للترجمة
     * @return void
     */
    const translateRow = (item: Blog) => {
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


const getColumns = ({ onEdit, onDelete, onTranslate }: ButtonsActions): ExtendedColumnDef<Blog>[] => [
    {
        accessorKey: "id", header: "ID",
        cell: centeredTextCell
    },
    {
        accessorKey: "title", header: "عنوان المدونة",
        cell: descriptionCell
    },
    {
        accessorKey: "excerpt", header: 'المقتطف',
        cell: descriptionCell
    },
    {
        accessorKey: "author", header: "المؤلف",
        cell: textCell
    },
    {
        accessorKey: "views", header: "عدد المشاهدات",
        cell: textCell
    },
    {
        accessorKey: "created_at", header: "تاريخ الإنشاء",
        cell: dateCell
    },
    {
        header: "Actions", accessorKey: "actions", nonHideable: true,
        cell: actionsCell(onEdit, onDelete, onTranslate)
    },
];
