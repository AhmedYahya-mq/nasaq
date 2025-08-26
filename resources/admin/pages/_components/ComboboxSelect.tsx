import * as React from "react";
import { Check, ChevronsUpDown } from "lucide-react";

import { cn } from "@/lib/utils";
import { Button } from "@/components/ui/button";
import {
    Command,
    CommandEmpty,
    CommandGroup,
    CommandInput,
    CommandItem,
    CommandList,
} from "@/components/ui/command";
import { Popover, PopoverContent, PopoverTrigger } from "@/components/ui/popover";
import { ComboboxSelectProps } from "@/types/membership";





export function ComboboxSelect({
    data,
    commandEmptyText,
    placeholder,
    className,
    onSelect,
    value,
}: ComboboxSelectProps) {
    const [open, setOpen] = React.useState(false);

    return (
        <div className={className}>
            <Popover open={open} onOpenChange={setOpen}>
                <PopoverTrigger asChild>
                    <Button
                        variant="outline"
                        role="combobox"
                        aria-expanded={open}
                        className="w-full justify-between"
                    >
                        {value
                            ? data.find((element) => element.value === value)?.label
                            : commandEmptyText}
                        <ChevronsUpDown className="opacity-50" />
                    </Button>
                </PopoverTrigger>
                <PopoverContent className="w-full p-0">
                    <Command>
                        <CommandInput placeholder={placeholder} className="h-9 rtl:rtl" />
                        <CommandList>
                            <CommandEmpty>{commandEmptyText}</CommandEmpty>
                            <CommandGroup>
                                {data.map((element) => (
                                    <CommandItem
                                        key={element.value}
                                        value={element.value}
                                        className={cn(
                                            "hover:primary-badge-hover",
                                            value === element.value && "primary-bg"
                                        )}
                                        onSelect={(currentValue: any) => {
                                            onSelect(currentValue === value ? "" : currentValue);
                                            setOpen(false);
                                        }}
                                    >
                                        {element.label}
                                        <Check
                                            className={cn(
                                                "ml-auto text-primary",
                                                value === element.value ? "opacity-100" : "opacity-0"
                                            )}
                                        />
                                    </CommandItem>
                                ))}
                            </CommandGroup>
                        </CommandList>
                    </Command>
                </PopoverContent>
            </Popover>
        </div>
    );
}
