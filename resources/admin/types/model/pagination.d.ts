interface PaginationProps {
    total: number;
    count: number;
    per_page: number;
    current_page: number;
    total_pages: number;
    links: {
        url: string | null;
        label: string;
        active: boolean;
        page: number | null;
    }[];
    to: number;
    from: number | null;
    last_page: number;
}

interface PaginatedData<T> {
    data: T[];
    meta: PaginationProps;
    links: Links;
}

interface Links{
    first: string | null;
    last: string | null;
    prev: string | null;
    next: string | null;
}