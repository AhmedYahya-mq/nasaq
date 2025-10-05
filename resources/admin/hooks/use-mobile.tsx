import { useEffect, useState } from 'react';

export function useIsMobile(customBreakpoint: number = 768) {
    const [isMobile, setIsMobile] = useState<boolean>();

    useEffect(() => {
        const mql = window.matchMedia(`(max-width: ${customBreakpoint - 1}px)`);

        const onChange = () => {
            setIsMobile(window.innerWidth < customBreakpoint);
        };

        mql.addEventListener('change', onChange);
        setIsMobile(window.innerWidth < customBreakpoint);

        return () => mql.removeEventListener('change', onChange);
    }, [customBreakpoint]);

    return !!isMobile;
}
