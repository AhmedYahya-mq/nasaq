import { JSX } from "react";
import { useTableMemberships } from "@/hooks/table/useTableMemberships";
import SectionListGeneric from "../SectionListGeneric";
import FormComponent from "./FormComponent";
import { usePage } from "@inertiajs/react";
import { Membership } from "@/types/model/membership.d";
import { membershipColumnLabels } from "@/tables/labels";

export default function SectionListMemberships(): JSX.Element {
    const { memberships } = usePage<{ memberships: Membership[] }>().props;
    const {
        tableData,
        addRow,
        updateRow,
        deleteRow,
        editRow,
        translateRow,
        setColumns,
        ...hookProps
    } = useTableMemberships({ memberships });

    const genericListProps = { ...hookProps, deleteRow };
    const formProps = { addRow, updateRow };

    return (
        <>
            <SectionListGeneric initHook={genericListProps} columnLabels={membershipColumnLabels} >
            </SectionListGeneric>
            <FormComponent tableHook={formProps} />
        </>
    );
}
