import SectionListGeneric from "../SectionListGeneric";
import FormComponent from "./FormComponent";
import { usePage } from "@inertiajs/react";
import { useTableCoupon } from "@/hooks/table/useTableCoupon";
import { CouponColumnLabels } from "@/tables/labels/CouponColumnLabels";

export default function SectionListCoupons() {
    const coupons = (usePage().props.coupons as Pagination<CouponModel>);

    const {
        table,
        addRow,
        updateRow,
        deleteRow,
        editRow,
        setColumns,
        ...hookProps
    } = useTableCoupon({ coupons });

    const genericListProps = { ...hookProps, deleteRow, editRow, table, setColumns };
    const formProps = { addRow, updateRow };

    return (
        <>
            <SectionListGeneric initHook={genericListProps} columnLabels={CouponColumnLabels} />
            <FormComponent tableHook={formProps} />
        </>
    );
}
