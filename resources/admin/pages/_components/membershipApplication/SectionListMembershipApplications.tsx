import { JSX } from "react";
import { ComboboxSelect } from "../ComboboxSelect";
import { applicationStatusOptions, canResubmitOptions, paymentStatusOptions } from "@/data/membershipApplication/tableOptions";
import { useTableMembershipApplications } from "@/hooks/table/useTableMembershipApplications";
import { applications, columns } from "@/data/membershipApplication/tableData";
import SectionListGeneric from "../SectionListGeneric";
import DialogMembershipApplicationsCard from "./DialogMembershipApplicationsCard";

export default function SectionListMemberships(): JSX.Element {
    const initHook = useTableMembershipApplications({ applications, columns }) as any;
    return (
        <SectionListGeneric
            initHook={initHook}
            DialogComponent={DialogMembershipApplicationsCard}
        >
            <div className="flex  items-center flex-wrap gap-3.5 mt-6 mb-4" >
                <ComboboxSelect className="flex-1 min-w-[100px]" data={paymentStatusOptions} commandEmptyText={('حالة الدفع')} placeholder="حالة الدفع" onSelect={initHook.setPaymentStatusFilter} value={initHook.paymentStatusFilter} />
                <ComboboxSelect className="flex-1 min-w-[100px]" data={applicationStatusOptions} commandEmptyText={('حالة الطلب')} placeholder="حالة الطلب" onSelect={initHook.setApplicationStatusFilter} value={initHook.applicationStatusFilter} />
                <ComboboxSelect className="flex-1 min-w-[100px]" data={canResubmitOptions} commandEmptyText={('إعادة التقديم')} placeholder="إعادة التقديم" onSelect={initHook.setCanResubmitFilter} value={initHook.canResubmitFilter} />
            </div>
        </SectionListGeneric>
    );
}
