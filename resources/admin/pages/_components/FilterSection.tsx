import { Input } from "@/components/ui/input";
import { Button } from "@/components/ui/button";
import { Link, PlusIcon } from "lucide-react";
import OpenFormContext from "@/context/OpenFormContext";
import { useContext, useState } from "react";

interface FilterSectionProps {
    search: string;
    setSearch: (value: string) => void;
}

export default function FilterSection({
    search,
    setSearch,
}: FilterSectionProps) {
    const { openCreate } = useContext(OpenFormContext);
    const [value, setValue] = useState(search);

    return (
        <div className="flex flex-wrap justify-between gap-4 mx-6">
            <Input
                className="max-w-[250px] min-w-[100px]"
                placeholder="البحث..."
                value={value}
                type="search"
                onChange={(e) => { setValue(e.currentTarget.value); }}
                onKeyDown={(e) => {
                    if (e.key === 'Enter') {
                        setSearch(e.currentTarget.value);
                    }
                }}
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
