import { blogs, dashboard, membership, membershipApplications } from "@/routes/admin";
import { NavItem } from "@/types";
import { LayoutGrid, Mail, Users } from "lucide-react";

const mainNavItems: NavItem[] = [
    {
        title: 'Dashboard',
        href: dashboard(),
        icon: LayoutGrid,
        isActive: false,
    },
    {
        title: 'العضويات',
        href: "#",
        icon: Users,
        isActive: false,
        items: [
            {
                title: "أدارة العضويات",
                href: membership(),
                isActive: false,
            },
            {
                title: "طلبات العضويات",
                href: membershipApplications(),
                isActive: false,
            },
        ],
    },
    {
        title: 'المدونات',
        href: blogs(),
        icon: Users,
        isActive: false,
    },
];

const rightNavItems: NavItem[] = [
    {
        title: 'البريد الالكتروني',
        href: 'https://github.com/laravel/react-starter-kit',
        icon: Mail,
    },
];


export { mainNavItems, rightNavItems };
