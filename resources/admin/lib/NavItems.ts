import { dashboard, membership } from "@/routes/admin";
import { NavItem } from "@/types";
import { BookOpen, Box, Folder, LayoutGrid, Users } from "lucide-react";

const mainNavItems: NavItem[] = [
    {
        title: 'Dashboard',
        href: dashboard(),
        icon: LayoutGrid,
    },
    {
        title: 'العضويات',
        href: membership(),
        icon: Users,
    },
];

const rightNavItems: NavItem[] = [
    {
        title: 'Repository',
        href: 'https://github.com/laravel/react-starter-kit',
        icon: Folder,
    },
    {
        title: 'Documentation',
        href: 'https://laravel.com/docs/starter-kits#react',
        icon: BookOpen,
    },
];


export { mainNavItems, rightNavItems };
