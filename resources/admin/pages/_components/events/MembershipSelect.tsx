import * as React from "react";
import { Button } from "@/components/ui/button";
import { Popover, PopoverContent, PopoverTrigger } from "@/components/ui/popover";
import { Checkbox } from "@/components/ui/checkbox";
import { Label } from "@/components/ui/label";

interface Membership {
    id: number;
    name: string;
}

interface MembershipSelectProps {
    memberships: Membership[];
    defaultValue?: number[];
    onChange?: (value: number[] | null) => void;
}

export function MembershipSelect({ memberships, defaultValue, onChange }: MembershipSelectProps) {
    const [selected, setSelected] = React.useState<number[]>(Array.isArray(defaultValue) && defaultValue.length > 0 ? defaultValue : [0]);
    const [open, setOpen] = React.useState(false);
    console.log(selected);
    const handleToggle = (value: number) => {
        if (value === 0) {
            setSelected([0]);
            onChange?.(null);
        } else {
            const filtered = selected.filter((v) => v !== 0);
            const newSelected = filtered.includes(value)
                ? filtered.filter((v) => v !== value)
                : [...filtered, value];
            setSelected(newSelected);
            onChange?.(newSelected);
        }
    };

    return (
        <Popover open={open} onOpenChange={setOpen}>
            <PopoverTrigger asChild>
                <Button
                    variant="outline"
                    className="w-full max-w-full h-full max-h-24 whitespace-normal break-words text-start"
                >
                    {selected.includes(0)
                        ? "الكل"
                        : selected.length > 0
                            ? memberships
                                .filter((m) => {
                                    console.log(m.id, selected);
                                    
                                    return selected.includes(m.id);
                                })
                                .map((m) => m.name)
                                .join(", ")
                            : "اختر من يستطيع تسجيل..."}
                </Button>

            </PopoverTrigger>
            <PopoverContent className="w-60">
                <div className="flex flex-col gap-2 p-2">
                    <Label htmlFor="membership-all" className="flex items-center gap-2">
                        <Checkbox
                            id="membership-all"
                            checked={selected.includes(0)}
                            value="all"
                            onCheckedChange={() => handleToggle(0)}
                        >
                        </Checkbox>
                        الكل
                    </Label>
                    <hr />
                    {memberships.map((m) => (
                        <Label key={m.id} htmlFor={`membership-${m.id}`} className="flex items-center gap-2">
                            <Checkbox
                                key={m.id}
                                id={`membership-${m.id}`}
                                checked={selected.includes(m.id)}
                                onCheckedChange={() => handleToggle(m.id)}
                            >
                            </Checkbox>
                            {m.name}
                        </Label>

                    ))}
                </div>
            </PopoverContent>
        </Popover>
    );
}
