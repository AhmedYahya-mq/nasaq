
import { OpenFormContextType } from '@/types/context';
import { createContext } from 'react';


const OpenFormContext = createContext<OpenFormContextType>({
    isOpen: false,
    item: null,
    isTranslate:false
});

export default OpenFormContext;
