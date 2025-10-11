
import SectionListGeneric from "../SectionListGeneric";
import FormComponent from "./FormComponent";
import { usePage } from "@inertiajs/react";
import { EventModel } from "@/types/model/events";
import { useTableEvent } from "@/hooks/table/useTableEvent";
import { EventColumnLabels } from "@/tables/labels/EventColumnLabels";

export default function SectionListEvents() {
    const events = (usePage().props.events as Pagination<EventModel>);
    console.log(usePage().props);

    const {
        tableData,
        addRow,
        updateRow,
        deleteRow,
        editRow,
        translateRow,
        setColumns,
        ...hookProps
    } = useTableEvent({ events });


    const genericListProps = { ...hookProps, deleteRow };
    const formProps = { addRow, updateRow };

    return (
        <>
            <SectionListGeneric initHook={genericListProps} columnLabels={EventColumnLabels} >
            </SectionListGeneric>
            <FormComponent tableHook={formProps} />
        </>
    );
}
