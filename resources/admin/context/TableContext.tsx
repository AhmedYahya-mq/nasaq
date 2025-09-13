import { createContext, useContext, ReactNode, FC } from "react";

interface TableContextType {
  visibleColumns: number[];
  handleRowClick?: () => void;
}

const TableContext = createContext<TableContextType | undefined>(undefined);

interface TableProviderProps {
  children: ReactNode;
  value: TableContextType;
}

export const TableProvider: FC<TableProviderProps> = ({ children, value }) => {
  return <TableContext.Provider value={value}>{children}</TableContext.Provider>;
};

export const useTableContext = (): TableContextType => {
  const context = useContext(TableContext);
  if (!context) {
    throw new Error("useTableContext must be used within a TableProvider");
  }
  return context;
};
