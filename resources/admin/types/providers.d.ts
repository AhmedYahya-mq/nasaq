
interface OpenFormContextType {
    setOpen?: (value: boolean) => void;
}



interface OpenFormProviderProps<FormDataType = any> {
    useFormTem?: (
        editData: FormDataType,
        setOpen: React.Dispatch<React.SetStateAction<boolean>>,
        setEditData: React.Dispatch<React.SetStateAction<FormDataType>>
    ) => {
        form: any;
        isLoading: boolean;
        onSubmit: () => void;
        onUpdate: () => void;
        onDelete: () => void;
        setFormdata: (data: Partial<FormDataType>) => void;
        resetForm: () => void;
    };
    children: ReactNode;
}
