import { JSX } from "react";
import { TableCustomize, TableButton } from "@/components/table-customize";
import { TableHeader, TableRow, TableHead, TableBody } from "@/components/ui/table";
import { ChevronDownIcon, ChevronUpIcon } from "lucide-react";
import RowsProduct from "./memberships/RowMembership";
import { Card } from "@/components/ui/card";
import FooterTable from "../../components/FooterTable";
import { TableProps } from "@/types/index";

function TableMemberships({
    columns,
    table,
    isClient,
    setSelectedRow
}: TableProps): JSX.Element | null {

    if (!isClient) return null;

    return (
        <>
            <Card className="shadow-md rounded-lg border p-0 overflow-hidden mb-4">
                <TableCustomize className="shadow-md rounded-lg border" columns={columns}>
                    {(visibleColumns: number[]) => (
                        <>
                            <TableHeader>
                                <TableRow className="bg-accent/35">
                                    <TableHead className={"p-1 " + (visibleColumns.length === columns.length ? "hidden" : "")} />
                                    {visibleColumns.map((colIndex) => {
                                        const column = table.getColumn(columns[colIndex].accessorKey);
                                        const sortDirection = column?.getIsSorted();
                                        return (
                                            <TableHead
                                                key={colIndex}
                                                className="cursor-pointer border text-center"
                                                onClick={() => column?.toggleSorting()}
                                            >
                                                <div className="flex p-2 gap-1 items-center justify-center font-bold">
                                                    {column?.columnDef.header}
                                                    {{
                                                        asc: <ChevronDownIcon size={15} />,
                                                        desc: <ChevronUpIcon size={15} />,
                                                    }[sortDirection as "asc" | "desc"] ?? null}
                                                </div>
                                            </TableHead>
                                        );
                                    })}
                                </TableRow>
                            </TableHeader>

                            <TableBody>
                                {table.getRowModel().rows.map((row: any, rowIndex: number) => (
                                    <TableRow key={rowIndex} className="odd:bg-accent/25">
                                        <TableButton
                                            onClick={() => setSelectedRow(row.original)}
                                            hidden={visibleColumns.length === columns.length ? "hidden" : ""}
                                        />
                                        {visibleColumns.map((colIndex) => (
                                            <RowsProduct
                                                key={colIndex}
                                                row={row.original}
                                                accessorKey={columns[colIndex].accessorKey}
                                            />
                                        ))}
                                    </TableRow>
                                ))}
                            </TableBody>
                        </>
                    )}
                </TableCustomize>
            </Card>

            <FooterTable table={table} />
        </>
    );
}

export default TableMemberships;
