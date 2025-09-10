import React, { createContext, useContext, ReactNode, FC } from "react";

// 👀 تعريف شكل القيم المخزنة في السياق
interface TableContextType {
  visibleColumns: number[];
  handleRowClick?: () => void;
}

// 1️⃣ إنشاء TableContext مع النوع
const TableContext = createContext<TableContextType | undefined>(undefined);

// 2️⃣ توفير TableProvider
interface TableProviderProps {
  children: ReactNode;
  value: TableContextType;
}

export const TableProvider: FC<TableProviderProps> = ({ children, value }) => {
  return <TableContext.Provider value={value}>{children}</TableContext.Provider>;
};

// 3️⃣ استخدام TableContext
export const useTableContext = (): TableContextType => {
  const context = useContext(TableContext);
  if (!context) {
    throw new Error("useTableContext must be used within a TableProvider");
  }
  return context;
};
