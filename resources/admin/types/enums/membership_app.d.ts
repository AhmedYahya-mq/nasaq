import { Icon } from '@/components/icons/icon';

export interface MembershipAppStatues {
    color: string;
    icon: string;
    label: string;
    label_ar: string;
    message: string;
    value: "pending" | "approved" | "rejected" | "cancelled";
}

export interface MembershipAppEmploymentStatus {
    label: string;
    label_ar: string;
    value: string;
    Icon: string;
    color: string;
}
