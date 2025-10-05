import React, { useRef, useState, useEffect, ReactNode, FC, MouseEventHandler } from "react";
import { PlusIcon } from "lucide-react";
import { TableProvider, useTableContext } from "@/context/TableContext";
import { Table } from "./ui/table";

interface Column {
  nonHideable?: boolean;
}

interface TableCustomizeProps {
  children: ReactNode | ((visibleColumns: number[]) => ReactNode);
  columns?: Column[];
  className?: string;
}

const TableCustomize: FC<TableCustomizeProps> = ({ children, columns = [], className = "" }) => {
  const tableRef = useRef<HTMLDivElement>(null);
  const [visibleColumns, setVisibleColumns] = useState<number[]>(columns.map((_, index) => index));

  useEffect(() => {
    const table = tableRef.current;
    if (!table) return;

    const checkScrollAndColumns = () => {
      const tableWidth = table.clientWidth;
      const columnWidth = 120;
      const maxVisibleColumns = Math.floor(tableWidth / columnWidth);
      const nonHideableColumns = columns
        .map((col, index) => (col.nonHideable ? index : null))
        .filter((index): index is number => index !== null);

      const newVisibleColumns: number[] = [...nonHideableColumns];

      for (let i = 0; i < columns.length; i++) {
        if (newVisibleColumns.length >= maxVisibleColumns) break;
        if (!newVisibleColumns.includes(i)) newVisibleColumns.push(i);
      }

      newVisibleColumns.sort((a, b) => a - b);
      setVisibleColumns(newVisibleColumns);
    };

    const resizeObserver = new ResizeObserver(checkScrollAndColumns);
    resizeObserver.observe(table);

    window.addEventListener("resize", checkScrollAndColumns);

    checkScrollAndColumns();

    return () => {
      resizeObserver.disconnect();
      window.removeEventListener("resize", checkScrollAndColumns);
    };
  }, [columns]);

  return (
    <TableProvider value={{ visibleColumns }}>
      <div ref={tableRef} className="scrollbar *:!overflow-x-visible">
        <Table className={className}>
          {typeof children === "function" ? children(visibleColumns) : children}
        </Table>
      </div>
    </TableProvider>
  );
};

interface TableButtonProps {
  onClick?: MouseEventHandler<HTMLDivElement>;
  hidden?: string;
}

const TableButton: FC<TableButtonProps> = ({ onClick, hidden, ...props }) => {
  const { handleRowClick } = useTableContext();
  return (
    <td className={"border p-1 w-[20px] " + (hidden || "")} {...props}>
      <div
        className="rounded-full cursor-pointer w-[20px] h-[20px] shadow-[0_0px_3px_rgba(0,0,0,0.3)] shadow-primary flex justify-center items-center"
        onClick={onClick || handleRowClick}
      >
        <PlusIcon size={15} className="rounded-full bg-primary" />
      </div>
    </td>
  );
};

export { TableCustomize, TableButton };
