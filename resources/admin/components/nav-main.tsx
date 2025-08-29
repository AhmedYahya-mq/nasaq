"use client"

import { SidebarGroup, SidebarGroupLabel, SidebarMenu } from "@/components/ui/sidebar"
import { type NavItem } from "@/types"
import NavItemComponent from "./nav-item"

export function NavMain({ items }: { items: NavItem[] }) {
    return (
        <SidebarGroup className="px-2 py-0">
            <SidebarGroupLabel>Platform</SidebarGroupLabel>
            <SidebarMenu>
                {items.map((item) => (
                    <NavItemComponent key={item.title} item={item} />
                ))}
            </SidebarMenu>
        </SidebarGroup>
    )
}
