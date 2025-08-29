import React, { JSX } from "react";
import { RowsProps } from "@/types";
import { flexRender } from "@tanstack/react-table";



export default function Row({ cell, accessorKey }: RowsProps): JSX.Element {

    return (
        <>
            {flexRender(cell.column.columnDef.cell, cell.getContext())}
        </>
    );
}
