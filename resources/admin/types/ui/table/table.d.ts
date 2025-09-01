import { ColumnDef } from '@tanstack/react-table';

export interface TableProps {
    columns: any[];
    table: any;
    isClient: boolean;
    setSelectedRow: (v: any) => void;
}

export interface RowsProps {
    cell: any;
    accessorKey: string;
}

export type ExtendedColumnDef<TData, TValue = any> = ColumnDef<TData, TValue> & {
    nonHideable?: boolean;
};
