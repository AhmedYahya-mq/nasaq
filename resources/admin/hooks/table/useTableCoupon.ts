import { useState, useMemo, useEffect, useContext } from "react";
import OpenFormContext from "@/context/OpenFormContext";
import axios from "axios";
import { toast } from "sonner";
import { getErrorMessage } from "@/lib/utils";
import { getCoreRowModel, getFilteredRowModel, getSortedRowModel, useReactTable } from "@tanstack/react-table";
import { ExtendedColumnDef, ButtonsActions } from "@/types";
import { confirmAlertDialog } from "@/components/custom/ConfirmDialog";
import { actionsCell, badgeCell, centeredTextCell, dateCell } from "@/components/table";
import { destroy } from "@/routes/admin/coupons";
import { coupons as index } from "@/routes/admin";
import { router } from "@inertiajs/react";
import { statusCell } from "@/components/table/cells/statusCell";
import { discountCell } from "@/components/table/cells/discountCell";

export function useTableCoupon({ coupons }: { coupons: Pagination<CouponModel> }) {
    const [search, setSearch] = useState<string>("");
    const [isClient, setIsClient] = useState(false);
    const [tableData, setTableData] = useState<CouponModel[]>(coupons?.data);
    const [meta, setMeta] = useState(coupons?.meta);
    const [links, setLinks] = useState(coupons?.links);
    const [selectedRow, setSelectedRow] = useState<CouponModel | null>(null);
    const { openEdit } = useContext(OpenFormContext);
    const [columns, setColumns] = useState<any[]>([]);

    useEffect(() => {
        setIsClient(true);
        setColumns(getColumns({ onEdit: editRow, onDelete: deleteRow }));
    }, []);

    const filteredData = useMemo(() => {
        return tableData.filter((item) => {
            return (!search || Object.values(item).some((val) => String(val ?? "").toLowerCase().includes(search.toLowerCase())));
        });
    }, [tableData, search]);

    const searchData = (text: string) => {
        setSearch(text);
        router.visit(
            index().url,
            {
                data: { search: text },
                preserveState: true, preserveScroll: true,
                onSuccess: (page) => {
                    const pageCoupons = page.props.coupons as Pagination<CouponModel>;
                    setTableData(pageCoupons.data);
                    setMeta(pageCoupons.meta);
                    setLinks(pageCoupons.links);
                }

            }
        );
    };

    const addRow = (coupon: CouponModel) => {
        setTableData(prev => [coupon, ...prev]);
        toast.success(`تم إضافة الكوبون ${coupon.code} بنجاح`);
    };

    const updateRow = (coupon: CouponModel) => {
        setTableData(prev => prev.map(row => (row.id === coupon.id ? coupon : row)));
        toast.success(`تم تحديث الكوبون ${coupon.code} بنجاح`);
    };

    const deleteRow = async (item: CouponModel) => {
        const ok = await confirmAlertDialog({
            title: "هل أنت متأكد؟",
            description: `سيتم حذف الكوبون ${item.code} نهائيًا.`,
        });
        if (!ok) return false;
        const toastId = toast.loading(`جاري حذف الكوبون ${item.code}...`);
        let isSuccess = false;
        await axios.delete(destroy(item.id).url).then(() => {
            setTableData(prev => prev.filter(row => row.id !== item.id));
            toast.success(`تم حذف الكوبون ${item.code} بنجاح`);
            isSuccess = true;
        }).catch((error) => {
            toast.error(getErrorMessage(error.status, `الكوبون ${item.code}`));
        }).finally(() => {
            toast.dismiss(toastId);
        });
        return isSuccess;
    };

    const editRow = (item: CouponModel) => {
        openEdit?.(item as any);
    };

    const changePage = (url: string | null) => {
        if (url) {
            router.visit(
                url,
                {
                    preserveState: true, preserveScroll: true,
                    onSuccess: (page) => {
                        const pageCoupons = page.props.coupons as Pagination<CouponModel>;
                        setTableData(pageCoupons.data);
                        setMeta(pageCoupons.meta);
                        setLinks(pageCoupons.links);
                    }
                }
            );
        }
    };

    const changePageSize = (size: number, path: string) => {
        router.visit(
            path,
            {
                data: { per_page: size },
                preserveState: true, preserveScroll: true,
                onSuccess: (page) => {
                    const pageCoupons = page.props.coupons as Pagination<CouponModel>;
                    setTableData(pageCoupons.data);
                    setMeta(pageCoupons.meta);
                    setLinks(pageCoupons.links);
                }

            }
        );

    };

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
    };
}



const getColumns = ({ onEdit, onDelete }: ButtonsActions): ExtendedColumnDef<CouponModel>[] => [
    {
        accessorKey: "id",
        header: "ID",
        cell: centeredTextCell,
    },
    {
        accessorKey: "code",
        header: "الكود",
        cell: centeredTextCell,
    },
    {
        accessorKey: "discount_type",
        header: "نوع الخصم",
        cell: centeredTextCell,
    },
    {
        accessorKey: "value",
        header: "قيمة الخصم",
        cell: ({ row }) => discountCell(row.original.value, row.original),
    },
    {
        accessorKey: "applies_to_label",
        header: "يطبق على",
        cell: centeredTextCell,
    },
    {
        accessorKey: "max_uses",
        header: "الحد الأقصى",
        cell: centeredTextCell,
    },
    {
        accessorKey: "used_count",
        header: "عدد الاستخدام",
        cell: centeredTextCell,
    },
    {
        accessorKey: "remaining_uses",
        header: "المتبقي",
        cell: centeredTextCell,
    },
    {
        accessorKey: "starts_at",
        header: "يبدأ في",
        cell: dateCell(),
    },
    {
        accessorKey: "expires_at",
        header: "ينتهي في",
        cell: dateCell(),
    },
    {
        accessorKey: "status",
        header: "الحالة",
        cell: ({ row }) => statusCell(row.original.status),
        nonHideable: true,
    },
    {
        accessorKey: "actions",
        header: "Actions",
        cell: actionsCell({ onEdit, onDelete }),
        nonHideable: true,
    }
];
