import { dashboard, membership, membershipApplications } from "@/routes/admin";
import { NavItem } from "@/types";
import { BookOpen, Box, Folder, LayoutGrid, Users } from "lucide-react";

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
        title: 'Components',
        href: '#',
        icon: Box,
        isActive: false,
        items: [
            {
                title: 'UI Elements',
                href: '#',
                isActive: false,
            },
            {
                title: 'Forms',
                href: '#',
                isActive: false,
            },
            {
                title: 'Cards',
                href: '#',
                isActive: false,
            },
            {
                title: 'Modals',
                href: '#',
                isActive: false,
            },
            {
                title: 'Tables',
                href: '#',
                isActive: false,
            },
            {
                title: 'Charts',
                href: '#',
                isActive: false,
            },
        ],
    },
    {
        title: 'Documentation',
        href: 'https://reactjs.org/docs/getting-started.html',
        icon: BookOpen,
        isActive: false,
    },
];

const rightNavItems: NavItem[] = [
    // {
    //     title: 'Repository',
    //     href: 'https://github.com/laravel/react-starter-kit',
    //     icon: Folder,
    // },
    // {
    //     title: 'Documentation',
    //     href: 'https://laravel.com/docs/starter-kits#react',
    //     icon: BookOpen,
    // },
];


export { mainNavItems, rightNavItems };
