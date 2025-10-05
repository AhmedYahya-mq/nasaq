import { ColumnDef } from "@tanstack/react-table";
import { MembershipAppEmploymentStatus, MembershipAppStatues } from "../enums/membership_app";

export interface MembershipApplication {
    id: number;
    user?: MembershipUser;
    status: MembershipAppStatues;
    employment_status?: MembershipAppEmploymentStatus;
    membership_type: string;
    national_id: string;
    scfhs_number: string;
    created_at_human: string;
    current_employer: string;
    admin_notes?: string;
    notes?: string;
    reviewed_at?: string;
    submitted_at: string;
    approved_at?: string;
    rejected_at?: string;
    files: MembershipFile[];
}

export interface UseTableMembershipApplicationsProps {
    applications: MembershipApplication[];
    columns: ColumnDef<MembershipApplication>[];
}


export interface MembershipFile{
    id: number;
    file_name: string;
    file_path: string;
    file_type: string;
    created_at: string;
    updated_at: string;
    url: string; // Accessor
}
