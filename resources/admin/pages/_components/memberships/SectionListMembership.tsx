import React, { JSX } from "react";
import { useTableMemberships } from "@/hooks/table/useTableMemberships";
import TableOrders from "../Table";
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";
import DialogOrderCard from "./DialogOrderCard";
import { memberships, columns } from "@/data/membership/tableData";
import FilterSection from "../FilterSection";
import { ComboboxSelect } from "../ComboboxSelect";

export default function SectionListMemberships(): JSX.Element {
    const {
        selectedRow,
        setSelectedRow,
        search,
        setSearch,
        isClient,
        table
    } = useTableMemberships({memberships, columns}) as any;

    return (
        <Card className="">
            {/* <CardHeader>
                <CardTitle> {('Filter')} </CardTitle>
                <div className="flex  items-center flex-wrap gap-3.5 mt-6 mb-4" >
                    <ComboboxSelect className="flex-1 min-w-[100px]" data={paymentMethods} commandEmptyText={('Payment Method')} placeholder="Payment Method" onSelect={setPaymentMethodFilter} value={paymentMethodFilter} />
                    <ComboboxSelect className="flex-1 min-w-[100px]" data={statusOptions} commandEmptyText={('Order status')} placeholder="Order status" onSelect={setStatusFilter} value={statusFilter} />
                    <ComboboxSelect className="flex-1 min-w-[100px]" data={installmentOptions} commandEmptyText={('Order installment')} placeholder="Order installment" onSelect={setInstallmentFilter} value={installmentFilter} />
                </div>
            </CardHeader> */}
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
