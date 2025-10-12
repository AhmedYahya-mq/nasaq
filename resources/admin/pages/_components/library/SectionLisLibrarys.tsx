import { JSX } from "react";

import SectionListGeneric from "../SectionListGeneric";
import FormComponent from "./FormComponent";
import { usePage } from "@inertiajs/react";
import { useTableMembers } from "@/hooks/table/useTableMembers";
import { Members } from "@/types/model/members";
import { membersColumnLabels } from "@/tables/labels";
import { Resource } from "@/types/model/resources";
import { useTableResource } from "@/hooks/table/useTableRecource";
import { resourceColumnLabels } from "@/tables/labels/ResourceColumnLabels";

export default function SectionLisLibrarys(): JSX.Element {
    const resources = (usePage().props.resources as Pagination<Resource>);


        const {
            tableData,
            addRow,
            updateRow,
            deleteRow,
            editRow,
            translateRow,
            setColumns,
            ...hookProps
        } = useTableResource({ resources })


    const genericListProps = { ...hookProps };
    const formProps = { addRow, updateRow };

    return (
        <>
            <SectionListGeneric initHook={genericListProps} columnLabels={resourceColumnLabels} >
            </SectionListGeneric>
            <FormComponent tableHook={formProps} />
        </>
    );
}
