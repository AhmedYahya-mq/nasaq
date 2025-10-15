import { JSX } from "react";

import SectionListGeneric from "../SectionListGeneric";
import FormComponent from "./FormComponent";
import { usePage } from "@inertiajs/react";
import { useTableMembers } from "@/hooks/table/useTableMembers";
import { Members } from "@/types/model/members";
import { membersColumnLabels } from "@/tables/labels";

export default function SectionListMembers(): JSX.Element {
     const members = (usePage().props.members as Pagination<Members>);

    const {
        tableData,
        addRow,
        updateRow,
        setColumns,
        ...hookProps
    } = useTableMembers({ members });


    const genericListProps = { ...hookProps };
    const formProps = { addRow, updateRow };

    return (
        <>
            <SectionListGeneric initHook={genericListProps} columnLabels={membersColumnLabels} >
            </SectionListGeneric>
            <FormComponent tableHook={formProps} />
        </>
    );
}
