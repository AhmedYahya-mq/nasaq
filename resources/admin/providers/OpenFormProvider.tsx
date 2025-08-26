import React, { ReactNode, useState } from "react";
import OpenFormContext from "@/context/OpenFormContext";


const OpenFormProvider = <FormDataType,>({
  useFormTem,
  children,
}: OpenFormProviderProps<FormDataType>) => {
  const [open, setOpen] = useState<boolean>(false);
  const [editData, setEditData] = useState<FormDataType>({} as FormDataType);

  const {
    form,
    isLoading,
    onSubmit,
    onUpdate,
    onDelete,
    setFormdata,
    resetForm,
  } = useFormTem?.(editData, setOpen, setEditData) ?? {};

  const value = {
    open,
    setOpen,
    editData,
    setEditData,
    form,
    isLoading,
    onSubmit,
    onUpdate,
    onDelete,
    setFormdata,
    resetForm,
  };

  return <OpenFormContext.Provider value={value}>{children}</OpenFormContext.Provider>;
};

export default OpenFormProvider;
