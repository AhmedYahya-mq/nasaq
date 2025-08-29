"use client";
import { TableCustomize, TableButton } from "@/components/table-customize";
import { TableHeader, TableRow, TableHead, TableBody } from "@/components/ui/table";
import { ChevronDownIcon, ChevronUpIcon } from "lucide-react";
import RowsProduct from "./RowOrder";
import { Card } from "@/components/ui/card";
import FooterTable from "../../../components/FooterTable";
function TableOrders({
  columns,
  table,
  isClient,
  setSelectedRow
}) {

  if (!isClient) return null;

  return (
    <>
      {/* الجدول */}
      <Card className="shadow-md rounded-lg border p-0 overflow-hidden mb-4">
        <TableCustomize className="shadow-md rounded-lg border" columns={columns}>
          {(visibleColumns) => (
            <>
              <TableHeader>
                <TableRow className="bg-accent/35">
                  <TableHead className={"p-1 " + (visibleColumns.length == columns.length ? "hidden" : "")} />
                  {visibleColumns.map((colIndex) => (
                    <TableHead key={colIndex} className="cursor-pointer border text-center " onClick={() => table.getColumn(columns[colIndex].accessorKey)?.toggleSorting()}>
                      <div className="flex p-2 gap-1 items-center justify-center font-bold">
                        {table.getColumn(columns[colIndex].accessorKey).columnDef.header}
                        {{
                          asc: <ChevronDownIcon size={15} />,
                          desc: <ChevronUpIcon size={15} />,
                        }[table.getColumn(columns[colIndex].accessorKey)?.getIsSorted()] ?? null}
                      </div>
                    </TableHead>
                  ))}
                </TableRow>
              </TableHeader>
              <TableBody>
                {table.getRowModel().rows.map((row, rowIndex) => (
                  <TableRow key={rowIndex} className="odd:bg-accent/25">
                    <TableButton onClick={() => setSelectedRow(row.original)} hidden={visibleColumns.length == columns.length ? "hidden" : ""} />
                    {visibleColumns.map((colIndex) => (
                      <RowsProduct key={colIndex} row={row.original} accessorKey={columns[colIndex].accessorKey} />
                    ))}
                  </TableRow>
                ))}
              </TableBody>
            </>
          )}
        </TableCustomize>
      </Card>

      {/* عناصر التحكم في التقسيم */}
      <FooterTable table={table} />
    </>
  );
}

export default TableOrders;