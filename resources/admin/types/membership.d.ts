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





