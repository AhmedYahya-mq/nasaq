import { Input } from "@/components/ui/input";
import { Button } from "@/components/ui/button";
import { Link, PlusIcon } from "lucide-react";
import OpenFormContext from "@/context/OpenFormContext";
import { useContext } from "react";

interface FilterSectionProps {
    search: string;
    setSearch: (value: string) => void;
}

export default function FilterSection({
    search,
    setSearch,
}: FilterSectionProps) {
    const { openCreate } = useContext(OpenFormContext);

    return (
        <div className="flex flex-wrap justify-between gap-4 mx-6">
            <Input
                className="max-w-[250px] min-w-[100px]"
                placeholder="Search..."
                value={search}
                onChange={(e) => setSearch(e.target.value)}
            />
            <div className="flex flex-wrap items-center gap-4">
                <Button
                    className="flex-1"
                    variant="outline"
                    onClick={openCreate}
                >
                    <PlusIcon size={14} className="cursor" />
                </Button>
                {/* <DropdownMenuExport className="flex-1" /> */}
            </div>
        </div>
    );
}
