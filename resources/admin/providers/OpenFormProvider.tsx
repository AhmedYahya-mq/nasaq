
import {  useState } from "react";
import OpenFormContext from "@/context/OpenFormContext";
import { Membership } from "@/types/model/membership.d";
import {  OpenFormProviderProps } from "@/types/providers";
import { OpenFormContextType } from "@/types/context";


const OpenFormProvider = <FormDataType,>({
  children,
}: OpenFormProviderProps<FormDataType>) => {
  const [isOpen, setIsOpen] = useState(false);
  const [item, _setItem] = useState<Membership | null>(null);
  const [isTranslate, setIsTranslate] = useState(false);

  const openCreate = () => {
    _setItem(null);
    setIsOpen(true);
  };

  const openEdit = (editItem: Membership) => {
    _setItem(editItem ?? null);
    setIsOpen(true);
  };

  const openTranslate = (translateItem: Membership) => {
    _setItem(translateItem);
    setIsOpen(true);
    setIsTranslate(true);
  };

  const close = () => {
    setIsOpen(false);
  };

  const value: OpenFormContextType = {
    isOpen,
    item,
    openCreate,
    openEdit,
    close,
    // keep simple boolean setter for compatibility with existing type
    setOpen: (v: boolean) => setIsOpen(v),
    setItem: (v: any | null) => _setItem(v),
    setIsTranslate: (v: boolean) => setIsTranslate(v),
    openTranslate,
    isTranslate,
  };

  return (
    <OpenFormContext.Provider value={value}>
      {children}
    </OpenFormContext.Provider>
  );
};

export default OpenFormProvider;
