import { useState, useMemo, useEffect, useContext } from "react";
import OpenFormContext from "@/context/OpenFormContext";
import axios from "axios";
import { toast } from "sonner";
import { getErrorMessage } from "@/lib/utils";
import { getCoreRowModel, getFilteredRowModel, getPaginationRowModel, getSortedRowModel, useReactTable } from "@tanstack/react-table";
import { EventModel } from "@/types/model/events";
import { ExtendedColumnDef, ButtonsActions } from "@/types";
import { confirmAlertDialog } from "@/components/custom/ConfirmDialog";
import { actionsCell, badgeCell, centeredTextCell, dateCell, SwitchCell } from "@/components/table";
import { eventCell } from "@/components/table/cells/EventCell";
import { destroy, show, toggleFeatured } from "@/routes/admin/events";
import { router } from "@inertiajs/react";
export function useTableEvent({ events }: { events: Pagination<EventModel> }) {
    const [search, setSearch] = useState<string>("");
    const [isClient, setIsClient] = useState(false);
    const [tableData, setTableData] = useState<EventModel[]>(events.data);

    const [selectedRow, setSelectedRow] = useState<EventModel | null>(null);
    const { openEdit, openTranslate } = useContext(OpenFormContext);
    const [columns, setColumns] = useState<any[]>([]);

    useEffect(() => {
        setIsClient(true);
        setColumns(getColumns({ onEdit: editRow, onDelete: deleteRow, onTranslate: translateRow, onChangeFeature: onChangeFeature, onView: viewEvent, viewEvent: viewEvent }));
    }, []);

    // تصفية البيانات بناءً على نص البحث
    const filteredData = useMemo(() => {
        return tableData.filter((item) => {
            return (!search || Object.values(item).some((val) => String(val).toLowerCase().includes(search.toLowerCase())));
        });
    }, [tableData, search]);

    // إضافة صف جديد للجدول
    const addRow = (event: EventModel) => {
        setTableData(prev => [event, ...prev]);
        toast.success(`تم إضافة الحدث ${event.title} بنجاح`);
    };

    // تحديث بيانات صف موجود في الجدول
    const updateRow = (event: EventModel) => {
        setTableData(prev =>
            prev.map(row => (row.id === event.id ? event : row))
        );
        toast.success(`تم تحديث الحدث ${event.title} بنجاح`);
    };

    // استدعاء نافذة التأكيد لحذف صف
    const deleteRow = async (item: EventModel) => {
        const ok = await confirmAlertDialog({
            title: "هل أنت متأكد؟",
            description: `سيتم حذف الحدث ${item.title} نهائيًا.`
        });
        if (!ok) return;
        const toastId = toast.loading(`جاري حذف الحدث ${item.title}...`);
        let isSuccess = false;
        await axios.delete(destroy(item.ulid).url).then(() => {
            setTableData(prev => prev.filter(row => row.id !== item.id));
            toast.success(`تم حذف الحدث ${item.title} بنجاح`);
            isSuccess = true;
        }).catch((error) => {
            toast.error(getErrorMessage(error.status, `الحدث ${item.title}`))
        }).finally(() => {
            toast.dismiss(toastId);
        });
        return isSuccess;
    };


    // فتح نافذة التعديل لصف محدد
    const editRow = (item: EventModel) => {
        openEdit?.(item);
    };

    // فتح نافذة العرض لصف محدد
    const viewEvent = (item: EventModel) => {
        router.visit(show(item.ulid).url);
    };

    const translateRow = (item: EventModel) => {
        openTranslate?.(item);
    }

    const onChangeFeature = async (item: EventModel): Promise<boolean> => {
        const action = item.is_featured ? "إزالة من المميزة" : "تمييز";
        const ok = await confirmAlertDialog({
            title: "هل أنت متأكد؟",
            description: `سيتم ${action} الحدث ${item.title}.`
        });
        if (!ok) return item.is_featured;
        const toastId = toast.loading(`جاري ${action} الحدث ${item.title}...`);
        let updated: EventModel | null = null;
        try {
            const response = await axios.put(toggleFeatured(item.ulid).url);
            updated = response.data.event;
            setTableData(prev =>
                prev.map(row => (row.id === item.id ? updated! : row))
            );
            toast.success(`تم ${action} الحدث ${item.title} بنجاح`);
        } catch (error: any) {
            toast.error(getErrorMessage(error.status, `الحدث ${item.title}`));
        } finally {
            toast.dismiss(toastId);
        }
        return updated ? updated.is_featured : item.is_featured;
    }

    const changePage = (url: string | null) => {
        if (url) {
            router.visit(
                url,
                {
                    preserveState: true, preserveScroll: true,
                    onSuccess: (page) => {
                        setTableData((page.props.events as Pagination<EventModel>).data);
                    }
                }
            );
        }
    }

    const changePageSize = (size: number, path: string) => {
        router.visit(
            path,
            {
                data: { per_page: size },
                preserveState: true, preserveScroll: true,
                onSuccess: (page) => {
                    setTableData((page.props.events as Pagination<EventModel>).data);
                }

            }
        );

    }
    const table = useReactTable({
        data: tableData,
        columns,
        pageCount: events.meta.last_page,
        manualPagination: true,
        meta: {
            pagination: {
                links: events.links,
                meta: events.meta,
            },
            onChangePage: changePage,
            onChangePageSize: changePageSize,
        },
        getCoreRowModel: getCoreRowModel(),
        getSortedRowModel: getSortedRowModel(),
        getFilteredRowModel: getFilteredRowModel(),
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

// نفس أعمدة الجدول في tableData.tsx
const getColumns = ({ onEdit, onDelete, onTranslate, onChangeFeature, onView, viewEvent }: ButtonsActions): ExtendedColumnDef<EventModel>[] => [
    {
        accessorKey: "id",
        header: "ID",
        cell: centeredTextCell,
    },
    {
        accessorKey: "title",
        header: "الحدث",
        cell: eventCell,
    },
    {
        accessorKey: "event_type",
        header: "نوع الحدث",
        cell: badgeCell,
    },
    {
        accessorKey: "event_method",
        header: "عبر",
        cell: badgeCell,
    },
    {
        accessorKey: "event_category",
        header: "فئة الحدث",
        cell: badgeCell,
    },
    {
        accessorKey: "event_status",
        header: "حالة الحدث",
        cell: badgeCell,
    },
    {
        accessorKey: "is_featured",
        header: "مميز",
        cell: SwitchCell(onChangeFeature as (item: EventModel) => Promise<boolean>),
        nonHideable: true,
    },
    {
        accessorKey: "start_at",
        header: "تاريخ البداية",
        cell: dateCell(),
        nonHideable: true,
    },
    {
        accessorKey: "end_at",
        header: "تاريخ النهاية",
        cell: dateCell(),
    },
    {
        accessorKey: "actions",
        header: "Actions",
        cell: actionsCell({ onEdit, onDelete, onTranslate, onView }),
        nonHideable: true,
    }
];


