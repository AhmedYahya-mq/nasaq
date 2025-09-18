import { JSX, useContext, useMemo } from "react";
import { useTableMemberships } from "@/hooks/table/useTableMemberships";
import { getColumns } from "@/data/membership/tableData";
import SectionListGeneric from "../SectionListGeneric";
import FormComponent from "./FormComponent";
import { usePage } from "@inertiajs/react";
import { Blog, blogColumnLabels } from "@/types/model/blogs.d";
import { useTableBlogs } from "@/hooks/table/useTableBlogs";

export default function SectionListBlogs(): JSX.Element {
    const { blogs } = usePage<{ blogs: Blog[] }>().props;
    const {
        tableData,
        addRow,
        updateRow,
        deleteRow,
        editRow,
        translateRow,
        setColumns,
        ...hookProps
    } = useTableBlogs({ blogs });


    const genericListProps = { ...hookProps, deleteRow };
    const formProps = { addRow, updateRow };

    return (
        <>
            <SectionListGeneric initHook={genericListProps} columnLabels={blogColumnLabels} >
            </SectionListGeneric>
            <FormComponent tableHook={formProps} />
        </>
    );
}
