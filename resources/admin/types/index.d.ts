import { InertiaLinkProps } from '@inertiajs/react';
import { ColumnDef } from '@tanstack/react-table';
import { LucideIcon } from 'lucide-react';

export interface Auth {
    user: User;
}

export interface BreadcrumbItem {
    title: string;
    href: string;
}

export interface NavGroup {
    title: string;
    items: NavItem[];
}

export interface NavItem {
    title: string;
    href: NonNullable<InertiaLinkProps['href']>;
    icon?: LucideIcon | null;
    isActive?: boolean;
    items?: NavItem[];
}

export interface SharedData {
    name: string;
    quote: { message: string; author: string };
    auth: Auth;
    sidebarOpen: boolean;

    [key: string]: unknown;
}

export interface User {
    id: number;
    name: string;
    email: string;
    avatar?: string;
    email_verified_at: string | null;
    two_factor_enabled: boolean;
    created_at: string;
    updated_at: string;
    [key: string]: unknown; // This allows for additional properties...
}


// نوع Customer
export interface Customer {
    name: string;
    email: string;
    avatar: string;
}


interface TableProps {
    columns: any[];
    table: any;
    isClient: boolean;
    setSelectedRow: (v: any) => void;
}



interface RowsProps {
    cell: any;
    accessorKey: string;
}



interface ComboboxSelectProps {
    data: ComboboxItem[];
    commandEmptyText: string;
    placeholder?: string;
    className?: string;
    onSelect: (value: any) => void;
    value: string;
}


interface ComboboxItem {
    value: string;
    label: string;
}


export type ExtendedColumnDef<TData, TValue = any> = ColumnDef<TData, TValue> & {
    nonHideable?: boolean;
};

export interface ColumnLabels {
    label: string;
    prefix?: React.ReactNode;
    suffix?: React.ReactNode;
    render?: (value: any) => React.ReactNode;
}


export interface Links {
    first: string | null;
    last: string | null;
    prev: string | null;
    next: string | null;
}

export interface MetaPagination {
    total: number,
    count: number,
    per_page: number,
    current_page: number,
    total_pages: number,
    sort_by: string | null,
    sort_order: 'asc' | 'desc' | null,
}
