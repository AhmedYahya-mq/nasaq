import { AlertConfirmContextType } from '@/types/context';
import { createContext } from 'react';



/**
 * سياق تأكيد التنبيه (Alert/Confirm) لتوفير القيم والدوال الافتراضية للمزود
 */
const AlertConfirmContext = createContext<AlertConfirmContextType>({
    isOpen: false,
    item: null,
    setItem: () => { },
    onConfirm: async () => { },
    setIsOpen: () => { },
    handleDelete: () => { },
});


export default AlertConfirmContext;


