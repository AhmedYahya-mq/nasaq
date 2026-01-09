import { blogs, events, library, members, membership, membershipApplications, coupons } from "@/routes/admin";
import { NavItem } from "@/types";
import { Calendar, LayoutGrid, LibraryBigIcon, Mail, NewspaperIcon, TicketPercent, Users } from "lucide-react";

const mainNavItems: NavItem[] = [

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
            {
                title: 'الاعضاء',
                href: members(),
                isActive: false,
            }
        ],
    },
    {
        title: 'المدونات',
        href: blogs(),
        icon: NewspaperIcon,
        isActive: false,
    },
     {
        title: 'الفعاليات',
        href: events(),
        icon: Calendar,
        isActive: false,
    },
    {
        title: 'المكتبة',
        href: library(),
        icon: LibraryBigIcon,
        isActive: false,
    },
    {
        title: 'الكوبونات',
        href: coupons(),
        icon: TicketPercent,
        isActive: false,
    }
];

const rightNavItems: NavItem[] = [
    {
        title: 'البريد الالكتروني',
        href: 'https://mail.hostinger.com/?clearSession=true&_user=info@nasaqcommunity.com&_gl=1*1xwxjzy*_gcl_au*ODc1NjkwNDU5LjE3NTQxNDU2MjMuNjYyMDI4Njg0LjE3NjAzODg0MDIuMTc2MDM5MDkyOA..*_ga*MTEwNDE5MTQ1LjE3NTQxNDU2MjM.*_ga_73N1QWLEMH*czE3NjA0ODI0MTAkbzckZzEkdDE3NjA0ODI0MTgkajUyJGwwJGgzNzg4NjgwMDkkZDhIYmNyMkRWSHp2UUdwc1ZmT2IwdGQ0NTFNSXRDQ0VBVWc.',
        icon: Mail,
    },
];


export { mainNavItems, rightNavItems };
