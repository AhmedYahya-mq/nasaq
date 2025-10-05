import { MembershipAppEmploymentStatus, MembershipAppStatues } from '../enums/membership_app';
import { MembershipApplication } from './membershipApplication';
import { ColumnDef } from '@tanstack/react-table';
import { Membership } from './membership.d';
export interface Members{
    id: number;
    name: string;
    email: string;
    profile_photo_url?: string;
    phone?: string;
    birthday?: string;
    address?: string;
    job_title?: string;
    bio?: string;
    email_verified_at: string | null;
    two_factor_enabled: boolean;
    is_active: boolean;
    membership_name?: string;
    membership_id?: number | null;
    membership_status?: MembershipAppStatues;
    membership_expires_at?: string | null;
    membership_started_at?: string | null;
    membership_active?: boolean;
    employment_status?: MembershipAppEmploymentStatus;
    membership_Application?: MembershipApplication; 
    membership_Applications_count?: number;
    remaining_days?: number | null;
    created_at: string;
    updated_at: string;
    [key: string]: unknown;
}

export interface UseTableMembersProps {
    members: Members[];
    columns: ColumnDef<Members>[];
}
