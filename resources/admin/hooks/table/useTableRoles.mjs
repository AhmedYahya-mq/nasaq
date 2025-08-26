import { useState, useMemo, useEffect } from "react";
import {
  useReactTable,
  getCoreRowModel,
  getSortedRowModel,
  getFilteredRowModel,
  getPaginationRowModel,
} from "@tanstack/react-table";

export function useTableRoles({ roles, columns }) {
  const [selectedRow, setSelectedRow] = useState(null);
  const [search, setSearch] = useState("");
  const [isClient, setIsClient] = useState(false);

  useEffect(() => {
    setIsClient(true);
  }, []);

  const filteredData = useMemo(() => { 
    return roles.filter((item) => {
      return (
        (!search || Object.values(item).some((val) => String(val).toLowerCase().includes(search.toLowerCase())))
      );
    });
  }, [roles, search]);

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
