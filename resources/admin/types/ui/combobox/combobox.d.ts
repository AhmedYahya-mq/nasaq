export interface ComboboxItem {
    value: string;
    label: string;
}

export interface ComboboxSelectProps {
    data: ComboboxItem[];
    commandEmptyText: string;
    placeholder?: string;
    className?: string;
    onSelect: (value: any) => void;
    value: string;
}
