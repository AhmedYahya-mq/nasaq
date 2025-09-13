import { JSX } from "react";
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";
import FilterSection from "./FilterSection";
import Table from "./Table";
import DialogComponenet from "./DialogComponenet";
import { ColumnLabels } from "@/types";
interface HookProps {
    selectedRow: any | null;
    setSelectedRow: (v: any | null) => void;
    search: string;
    setSearch: (value: string) => void;
    isClient: boolean;
    table: any;
    columns: any[];
}

interface SectionListGenericProps {
    children?: React.ReactNode;
    initHook: HookProps;
    columnLabels?: Record<string, ColumnLabels>;
}

export default function SectionListGeneric({
    children,
    columnLabels,
    initHook
}: SectionListGenericProps): JSX.Element {
    return (
        <Card className="">
            <CardHeader>
                <CardTitle> {('Filter')} </CardTitle>
                {children}
            </CardHeader>
            <hr className="border-t border-accent" />
            <FilterSection
                search={initHook.search}
                setSearch={initHook.setSearch}
            />
            <hr className="border-t border-accent" />
            <CardContent>
                <Table isClient={initHook.isClient} columns={initHook.columns} table={initHook.table} setSelectedRow={initHook.setSelectedRow} />
                <DialogComponenet selectedRow={initHook.selectedRow} setSelectedRow={initHook.setSelectedRow} columnLabels={columnLabels} />
            </CardContent>
        </Card>
    );
}
