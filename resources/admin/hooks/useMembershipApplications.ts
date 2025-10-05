import { photoUpdate } from './../../js/actions/App/Http/Controllers/User/Settings/ProfileController';
import { useState, useEffect } from "react";
import axios from "axios";
import { membershipApplications } from "@/routes/admin";
import { MembershipApplication } from "@/types/model/membershipApplication";
import { usePage } from "@inertiajs/react";
import { updateBrowserUrl } from "@/lib/utils";

interface UseMembershipApplicationsProps {
    member_id?: number | string;
}

export function useMembershipApplications({ member_id }: UseMembershipApplicationsProps) {
    const page = usePage();
    const inertiaPagination = page.props.applications as PaginatedData<MembershipApplication>;
    const [pagination, setPagination] = useState<PaginatedData<MembershipApplication>>(inertiaPagination);
    const [loading, setLoading] = useState(false);
    const [searchQuery, setSearchQuery] = useState(page.props.filters?.search || '');
    const [selectedFolder, setSelectedFolder] = useState(page.props.filters?.status || '');
    const [currentPage, setCurrentPage] = useState(inertiaPagination?.meta?.current_page || 1);
    const [initialLoad, setInitialLoad] = useState(true);
    const [prevStatus, setPrevStatus] = useState(selectedFolder);

    // جلب البيانات من API
    const fetchApplications = async (params: any = {}) => {
        setLoading(true);
        try {
            const apiParams: any = {
                page: params.page || currentPage,
                member_id: member_id || '',
                search: params.search || searchQuery,
            };
            if (selectedFolder === "" && prevStatus !== "" && inertiaPagination) {
                setPagination(inertiaPagination);
                setPrevStatus("");
                if (!member_id) {
                    updateBrowserUrl(membershipApplications().url, { ...apiParams, status: '' });
                }
                return;
            };
            if (selectedFolder) {
                apiParams.status = selectedFolder;
            }
            setPrevStatus(selectedFolder);
            scrollTo(0, 0);
            const res = await axios.get(membershipApplications().url, { params: apiParams, headers: { 'Accept': 'application/json', 'type-api': 'api' } });
            if (!member_id) {
                updateBrowserUrl(membershipApplications().url, apiParams);
            }
            setPagination(res.data);
        } finally {
            setLoading(false);
        }
    };

    // أول تحميل أو أي تغيير على member_id
    useEffect(() => {
        fetchApplications({ page: 1 });
        setCurrentPage(1);
    }, [member_id]);

    // البحث + الفلترة + تغيير الصفحة
    useEffect(() => {
        if (initialLoad) {
            setInitialLoad(false);
            return;
        }
        fetchApplications({ page: 1, search: searchQuery });
        setCurrentPage(1);
    }, [searchQuery, selectedFolder]);

    const handlePageChange = (page: number) => {
        setCurrentPage(page);
        fetchApplications({ page });
    };

    return {
        pagination,
        loading,
        searchQuery,
        setSearchQuery,
        selectedFolder,
        setSelectedFolder,
        currentPage,
        handlePageChange,
        fetchApplications,
    };
}
