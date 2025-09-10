"use client";

import { useTableOrders } from "@/hooks/table/useTableOrders.mjs";
import TableOrders from "./TableOrder";
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";
import { statusOptions, paymentMethods, installmentOptions, rowsOptions } from "@/data/order/tableOptions.mjs";
import DialogOrderCard from "./DialogOrderCard";
import { orders, columns } from "@/data/order/tableData.mjs";
import FilterSection from "../FilterSection";
import { ComboboxSelect } from "../ComboboxSelect";
import { useTranslations } from "next-intl";

export default function SectionListOrder() {
    const t= useTranslations('dash')
    
    const {
        selectedRow,
        setSelectedRow,
        search,
        setSearch,
        statusFilter,
        setStatusFilter,
        installmentFilter,
        setInstallmentFilter,
        paymentMethodFilter,
        setPaymentMethodFilter,
        isClient,
        table
    } = useTableOrders({orders, columns});
    return (
        <Card className="">
            <CardHeader>
                <CardTitle> {t('Filter')} </CardTitle>
                <div className="flex  items-center flex-wrap gap-3.5 mt-6 mb-4" >
                    <ComboboxSelect className="flex-1 min-w-[100px]" data={paymentMethods} commandEmptyText={t('Payment Method')} placeholder="Payment Method" onSelect={setPaymentMethodFilter} value={paymentMethodFilter} />
                    <ComboboxSelect className="flex-1 min-w-[100px]" data={statusOptions} commandEmptyText={t('Order status')} placeholder="Order status" onSelect={setStatusFilter} value={statusFilter} />
                    <ComboboxSelect className="flex-1 min-w-[100px]" data={installmentOptions} commandEmptyText={t('Order installment')} placeholder="Order installment" onSelect={setInstallmentFilter} value={installmentFilter} />
                </div>
            </CardHeader>
            <hr className="border-t border-accent" />
            <FilterSection
                search={search}
                setSearch={setSearch}
            />
            <hr className="border-t border-accent" />
            <CardContent>
                <TableOrders isClient={isClient} columns={columns} table={table} setSelectedRow={setSelectedRow} />
                <DialogOrderCard selectedRow={selectedRow} setSelectedRow={setSelectedRow} />
            </CardContent>
        </Card>
    );
}
