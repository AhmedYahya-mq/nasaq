import { useState, useMemo, useEffect } from "react";
import {
  useReactTable,
  getCoreRowModel,
  getSortedRowModel,
  getFilteredRowModel,
  getPaginationRowModel,
} from "@tanstack/react-table";
import { Membership, UseTableMembershipsProps } from "@/types/membership";



export function useTableMemberships({ memberships , columns }: UseTableMembershipsProps) {
  const [selectedRow, setSelectedRow] = useState<Membership | null>(null);
  const [search, setSearch] = useState<string>("");
  const [isClient, setIsClient] = useState(false);

  useEffect(() => {
    setIsClient(true);
  }, []);

  const filteredData = useMemo(() => {
    return memberships.filter((item) => {
      return (
        (!search || Object.values(item).some((val) => String(val).toLowerCase().includes(search.toLowerCase())))
      );
    });
  }, [memberships, search]);

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
    isClient,
    table,
  };
}
