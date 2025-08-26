import { ColumnDef } from "@tanstack/react-table";

export interface Membership {
  id: number;
  name: string;
  description?: string;
  price: number;
}

interface UseTableMembershipsProps {
  memberships: Membership[];
  columns: ColumnDef<Membership>[];
}


interface ComboboxSelectProps {
  data: ComboboxItem[];
  commandEmptyText: string;
  placeholder?: string;
  className?: string;
  onSelect: (value: string) => void;
  value: string;
}


interface ComboboxItem {
  value: string;
  label: string;
}




interface RowsMembershipProps {
    row: any;
    accessorKey: string;
}


