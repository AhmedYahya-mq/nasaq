import { Membership } from "./model/membership.d";

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

interface AlertConfirmProviderProps {
    children: ReactNode;
    onConfirm: (id: string | number) => void;
}

export {
    OpenFormProviderProps,
    AlertConfirmProviderProps
};
