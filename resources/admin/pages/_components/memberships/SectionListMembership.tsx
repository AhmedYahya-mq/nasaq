import { JSX, useContext, useMemo } from "react";
import { useTableMemberships } from "@/hooks/table/useTableMemberships";
import { getColumns } from "@/data/membership/tableData";
import SectionListGeneric from "../SectionListGeneric";
import FormComponent from "./FormComponent";
import { usePage } from "@inertiajs/react";
import { Membership, membershipColumnLabels } from "@/types/model/membership.d";
import AlertConfirmContext from "@/context/AlertConfirmContext";

export default function SectionListMemberships(): JSX.Element {
    const { memberships } = usePage<{ memberships: Membership[] }>().props;
    const { handleDelete } = useContext(AlertConfirmContext);

    const {
        tableData,
        addRow,
        updateRow,
        deleteRow,
        editRow,
        translateRow,
        setColumns,
        ...hookProps
    } = useTableMemberships({ memberships, handleDelete });

    useMemo(
        () => {setColumns(getColumns({ onEdit: editRow, onDelete: deleteRow, onTranslate: translateRow }));},
        []
    );

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
