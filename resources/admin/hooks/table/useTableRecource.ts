
import { useState, useMemo, useEffect, useContext } from "react";
import OpenFormContext from "@/context/OpenFormContext";
import axios from "axios";
import { toast } from "sonner";
import { getErrorMessage } from "@/lib/utils";
import { getCoreRowModel, getFilteredRowModel, getSortedRowModel, useReactTable } from "@tanstack/react-table";
import { Resource } from "@/types/model/resources";
import { ExtendedColumnDef, ButtonsActions } from "@/types";
import { confirmAlertDialog } from "@/components/custom/ConfirmDialog";
import { actionsCell, badgeCell, centeredTextCell, dateCell } from "@/components/table";
import { router } from "@inertiajs/react";
import { destroy, download } from "@/routes/admin/library";
import { eventCell } from "@/components/table/cells/EventCell";
import useProgressToast from "./t";
import { DownloadManager } from "@/lib/download";
import { library } from "@/routes/admin";

export function useTableResource({ resources }: { resources: Pagination<Resource> }) {
    const [search, setSearch] = useState<string>("");
    const [isClient, setIsClient] = useState(false);
    const [tableData, setTableData] = useState<Resource[]>(resources?.data);
    const [meta, setMeta] = useState(resources?.meta);
    const [links, setLinks] = useState(resources?.links);
    const [selectedRow, setSelectedRow] = useState<Resource | null>(null);
    const { openEdit, openTranslate } = useContext(OpenFormContext);
    const [columns, setColumns] = useState<any[]>([]);

    useEffect(() => {
        setIsClient(true);
        setColumns(getColumns({ onEdit: editRow, onDelete: deleteRow, onTranslate: translateRow, onDownload: onDownload }));
    }, []);

    // تصفية البيانات بناءً على نص البحث
    const filteredData = useMemo(() => {
        return tableData.filter((res) => {
            return (!search || Object.values(res).some((val) => String(val).toLowerCase().includes(search.toLowerCase())));
        });
    }, [tableData, search]);

    // البحث في البيانات وتحديثها من الخادم
    const searchData = (text: string) => {
        setSearch(text);
        router.visit(
            library().url,
            {
                data: { search: text },
                preserveState: true, preserveScroll: true,
                onSuccess: (page) => {
                    setTableData((page.props.resources as Pagination<Resource>).data);
                    setMeta((page.props.resources as Pagination<Resource>).meta);
                    setLinks((page.props.resources as Pagination<Resource>).links);
                }

            }
        );
    }

    // إضافة صف جديد للجدول
    const addRow = (resource: Resource) => {
        setTableData(prev => [resource, ...prev]);
        toast.success(`تم إضافة المورد ${resource.title} بنجاح`);
    };

    // تحديث بيانات صف موجود في الجدول
    const updateRow = (resource: Resource) => {
        console.log(resource);

        setTableData(prev =>
            prev.map(row => (row.id === resource.id ? resource : row))
        );
        toast.success(`تم تحديث المورد ${resource.title} بنجاح`);
    };

    // استدعاء نافذة التأكيد لحذف صف
    const deleteRow = async (res: Resource) => {
        const ok = await confirmAlertDialog({
            title: "هل أنت متأكد؟",
            description: `سيتم حذف المورد ${res.title} نهائيًا.`
        });
        if (!ok) return;
        const toastId = toast.loading(`جاري حذف المورد ${res.title}...`);
        let isSuccess = false;
        await axios.delete(destroy(res.ulid).url).then(() => {
            setTableData(prev => prev.filter(row => row.id !== res.id));
            toast.success(`تم حذف المورد ${res.title} بنجاح`);
            isSuccess = true;
        }).catch((error) => {
            toast.error(getErrorMessage(error.status, `المورد ${res.title}`))
        }).finally(() => {
            toast.dismiss(toastId);
        });
        return isSuccess;
    };


    // فتح نافذة التعديل لصف محدد
    const editRow = (res: Resource) => {
        openEdit?.(res);
    };

    const translateRow = (res: Resource) => {
        openTranslate?.(res);
    }


    const { showToast, updateProgress, removeToast } = useProgressToast();
    const onDownload = (res: Resource) => {
        const fileUrl = download(res.ulid).url; // رابط التحميل

        const downloader = new DownloadManager(fileUrl, res.title_en ?? res.title ?? "file", {
            onStart: () => {
                showToast(); // عرض شريط التقدم
            },
            onProgress: (percent) => {
                updateProgress(percent);
            },
            onSuccess: () => {
                toast.success("✅ تم تنزيل الملف بنجاح!");
                removeToast();
            },
            onError: (error) => {
                toast.error("❌ فشل تحميل الملف");
                console.error(error);
                removeToast();
            },
        });

        downloader.start();
    };


    const changePage = (url: string | null) => {
        if (url) {
            router.visit(
                url,
                {
                    preserveState: true, preserveScroll: true,
                    onSuccess: (page) => {
                        setTableData((page.props.resources as Pagination<Resource>).data);
                        setMeta((page.props.resources as Pagination<Resource>).meta);
                        setLinks((page.props.resources as Pagination<Resource>).links);
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
                    setTableData((page.props.resources as Pagination<Resource>).data);
                    setMeta((page.props.resources as Pagination<Resource>).meta);
                    setLinks((page.props.resources as Pagination<Resource>).links);
                }

            }
        );

    }
    const table = useReactTable({
        data: tableData,
        columns,
        pageCount: meta?.last_page,
        manualPagination: true,
        meta: {
            pagination: {
                links: links,
                meta: meta,
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
        searchData,
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
const getColumns = ({ onEdit, onDelete, onTranslate, onDownload }: ButtonsActions): ExtendedColumnDef<Resource>[] => [
    {
        accessorKey: "id",
        header: "ID",
        cell: centeredTextCell,
    },
    {
        accessorKey: "title",
        header: "المصدر",
        cell: eventCell,
    },
    {
        accessorKey: "author",
        header: "المؤلف",
        cell: centeredTextCell,
    },
    {
        accessorKey: "type",
        header: "النوع",
        cell: badgeCell,
    },
    {
        accessorKey: "status",
        header: "الحالة",
        cell: badgeCell,
    },
    {
        accessorKey: "price",
        header: "السعر",
        cell: centeredTextCell,
    },
    {
        accessorKey: "user_count",
        // من حفظ الملف عنده
        header: "اقتنوا الكتاب",
        cell: centeredTextCell,
    },
    {
        accessorKey: "discount",
        header: "الخصم",
        cell: ({ getValue }) => {
            return centeredTextCell({ getValue: () => `${(getValue()) || 0}%` });
        },
    },
    {
        accessorKey: "published_at",
        header: "تاريخ النشر",
        cell: dateCell(false),
    },
    {
        accessorKey: "year_published",
        header: "سنة النشر",
        cell: centeredTextCell,
    },
    {
        accessorKey: "actions",
        header: "Actions",
        cell: actionsCell({ onEdit, onDelete, onTranslate, onDownload }),
        nonHideable: true,
    }
];


