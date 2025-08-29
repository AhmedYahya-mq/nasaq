import { ColumnDef } from "@tanstack/react-table";

export interface MembershipApplication {
  id: number;
  userId: number;
  membershipId: number;
  formData?: Record<string, any>; // البيانات الإضافية
  amount: number;
  paymentStatus: "Pending" | "Paid" | "Failed";
  applicationStatus: "Pending" | "Approved" | "Rejected";
  canResubmit: boolean;
  createdAt: string;
  updatedAt: string;
}


interface UseTableMembershipApplicationsProps {
  applications: MembershipApplication[];
  columns: ColumnDef<MembershipApplication>[];
}
