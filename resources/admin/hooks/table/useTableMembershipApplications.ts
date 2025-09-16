import { useState, useMemo, useEffect } from "react";
import {
  useReactTable,
  getCoreRowModel,
  getSortedRowModel,
  getFilteredRowModel,
  getPaginationRowModel,
} from "@tanstack/react-table";
import { MembershipApplication, UseTableMembershipApplicationsProps } from "@/types/model/membershipApplication";


export function useTableMembershipApplications({ applications , columns }: UseTableMembershipApplicationsProps) {
  const [selectedRow, setSelectedRow] = useState<MembershipApplication | null>(null);
  const [search, setSearch] = useState<string>("");
  const [isClient, setIsClient] = useState(false);
  const [paymentStatusFilter, setPaymentStatusFilter] = useState<any | null>(null);
  const [applicationStatusFilter, setApplicationStatusFilter] = useState<any | null>(null);
  const [canResubmitFilter, setCanResubmitFilter] = useState<any | null>(null);

  useEffect(() => {
    setIsClient(true);
  }, []);

  const filteredData = useMemo(() => {
    return applications.filter((item) => {
      return (
        (!search || Object.values(item).some((val) => String(val).toLowerCase().includes(search.toLowerCase()))) &&
        (!paymentStatusFilter || item.paymentStatus === paymentStatusFilter) &&
        (!applicationStatusFilter || item.applicationStatus === applicationStatusFilter) &&
        (!canResubmitFilter || String(item.canResubmit) === canResubmitFilter)
      );
    });
  }, [applications, search, paymentStatusFilter, applicationStatusFilter, canResubmitFilter]);

  const table = useReactTable({
    data: filteredData,
    columns,
    getCoreRowModel: getCoreRowModel(),
    getSortedRowModel: getSortedRowModel(),
    getFilteredRowModel: getFilteredRowModel(),
    getPaginationRowModel: getPaginationRowModel(),
    initialState: { pagination: { pageSize: 10 } },
  });

  return {
    selectedRow,
    setSelectedRow,
    search,
    setSearch,
    paymentStatusFilter,
    setPaymentStatusFilter,
    applicationStatusFilter,
    setApplicationStatusFilter,
    canResubmitFilter,
    setCanResubmitFilter,
    isClient,
    table,
    columns
  };
}
