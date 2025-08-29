"use client"

import { ChevronRight } from "lucide-react"
import { Link, usePage } from "@inertiajs/react"
import { type NavItem } from "@/types"

import {
    Collapsible,
    CollapsibleContent,
    CollapsibleTrigger,
} from "@/components/ui/collapsible"

import {
    SidebarMenuItem,
    SidebarMenuButton,
    SidebarMenuSub,
    SidebarMenuSubButton,
    SidebarMenuSubItem,
} from "@/components/ui/sidebar"


const isActiveLink = (pageUrl: string, href: string | { url: string }) => {
    const url = typeof href === "string" ? href : href.url
    return pageUrl === url
}

export default function ({ item }: { item: NavItem }) {
    const page = usePage()
    const hasChildren = item.items && item.items.length > 0

    const subItems = hasChildren
        ? item.items?.map((subItem) => ({
            ...subItem,
            isActive: isActiveLink(page.url, subItem.href),
        }))
        : []

    const isActive = hasChildren ? subItems?.some((s) => s.isActive) : isActiveLink(page.url, item.href)

    if (hasChildren) {
        return (
            <Collapsible
                asChild
                defaultOpen={isActive}
                className="group/collapsible"
            >
                <SidebarMenuItem>
                    <CollapsibleTrigger asChild>
                        <SidebarMenuButton
                        className="text-primary hover:text-foreground"
                        tooltip={item.title}>
                            <span className="flex gap-2">
                                {item.icon && <item.icon className="size-4" />}
                                <span>{item.title}</span>
                            </span>
                            <ChevronRight className="mr-auto transition-transform duration-200 group-data-[state=open]/collapsible:rotate-90" />
                        </SidebarMenuButton>
                    </CollapsibleTrigger>
                    <CollapsibleContent>
                        <SidebarMenuSub>
                            {subItems?.map((subItem) => (
                                <SidebarMenuSubItem key={subItem.title}>
                                    <SidebarMenuSubButton
                                        isActive={subItem.isActive}
                                        title={subItem.title}
                                        asChild
                                    >
                                        <Link href={subItem.href} prefetch>
                                            <span>{subItem.title}</span>
                                        </Link>
                                    </SidebarMenuSubButton>
                                </SidebarMenuSubItem>
                            ))}
                        </SidebarMenuSub>
                    </CollapsibleContent>
                </SidebarMenuItem>
            </Collapsible>
        )
    }

    return (
        <SidebarMenuItem>
            <SidebarMenuButton asChild isActive={isActive} tooltip={{ children: item.title }}>
                <Link href={item.href} prefetch>
                    {item.icon && <item.icon />}
                    <span>{item.title}</span>
                </Link>
            </SidebarMenuButton>
        </SidebarMenuItem>
    )
}
