import React, { JSX } from "react";
import { useTableMemberships } from "@/hooks/table/useTableMemberships";
import DialogMembershipsCard from "./DialogMembershipsCard";
import { memberships, columns } from "@/data/membership/tableData";
import SectionListGeneric from "../SectionListGeneric";

export default function SectionListMemberships(): JSX.Element {
	return (
		<SectionListGeneric
			initHook={useTableMemberships({ memberships, columns })}
			DialogComponent={DialogMembershipsCard}
		/>
	);
}
