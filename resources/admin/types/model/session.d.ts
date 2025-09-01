export type SessionInfo = {
    id: string;
    agent: {
        is_desktop: boolean;
        platform: string | null;
        browser: string | null;
    };
    ip_address: string;
    is_current_device: boolean;
    last_active: string;
};
