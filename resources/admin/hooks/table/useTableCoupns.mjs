import { useState, useMemo, useEffect, useCallback } from "react";
import {
  useReactTable,
  getCoreRowModel,
  getSortedRowModel,
  getFilteredRowModel,
  getPaginationRowModel,
} from "@tanstack/react-table";

// دالة مساعدة لتحويل التاريخ إلى كائن Date مرة واحدة
const parseDate = (date) => {
  if (!date) return null;
  const parsedDate = new Date(date);
  return isNaN(parsedDate) ? null : parsedDate;
};

export function useTableCoupons({ coupons, columns }) {
  const [selectedRow, setSelectedRow] = useState(null);
  const [search, setSearch] = useState("");
  const [statusFilter, setStatusFilter] = useState(undefined);
  const [discountTypeFilter, setDiscountTypeFilter] = useState(undefined);
  const [applicabilityFilter, setApplicabilityFilter] = useState(undefined);
  const [startDateFilter, setStartDateFilter] = useState(null);
  const [endDateFilter, setEndDateFilter] = useState(null);
  const [isClient, setIsClient] = useState(false);

  useEffect(() => {
    setIsClient(true);
  }, []);

  // تحسين البحث باستخدام useCallback
  const matchesSearch = useCallback((coupon, searchTerm) => {
    if (!searchTerm) return true;
    const searchLower = searchTerm.toLowerCase();
    return (
      coupon.couponCode.toLowerCase().includes(searchLower) ||
      coupon.discountValue.toLowerCase().includes(searchLower) ||
      (coupon.status && coupon.status.toLowerCase().includes(searchLower)) ||
      (coupon.applicability && coupon.applicability.toLowerCase().includes(searchLower))
    );
  }, []);

  // تحسين تصفية التاريخ
  const matchesDateRange = useCallback((couponStart, couponEnd, filterStart, filterEnd) => {
    return (
      (!filterStart || filterStart <= couponEnd) &&
      (!filterEnd || filterEnd >= couponStart)
    );
  }, []);

  // تحسين كبير في تصفية البيانات
  const filteredData = useMemo(() => {
    // إذا لم يكن هناك أي فلتر، نرجع البيانات كما هي
    if (!search && !statusFilter && !discountTypeFilter && 
        !applicabilityFilter && !startDateFilter && !endDateFilter) {
      return coupons;
    }

    // تحويل تواريخ الفلتر مرة واحدة فقط
    const startFilterDate = startDateFilter ? parseDate(startDateFilter) : null;
    const endFilterDate = endDateFilter ? parseDate(endDateFilter) : null;

    return coupons.filter((coupon) => {
      // تحويل تواريخ الكوبون مرة واحدة لكل كوبون
      const couponStart = parseDate(coupon.startDate);
      const couponEnd = parseDate(coupon.endDate);

      return (
        matchesSearch(coupon, search) &&
        (!statusFilter || coupon.status === statusFilter) &&
        (!discountTypeFilter || coupon.discountType === discountTypeFilter) &&
        (!applicabilityFilter || coupon.applicability === applicabilityFilter) &&
        matchesDateRange(couponStart, couponEnd, startFilterDate, endFilterDate)
      );
    });
  }, [coupons, search, statusFilter, discountTypeFilter, applicabilityFilter, 
      startDateFilter, endDateFilter, matchesSearch, matchesDateRange]);

  const table = useReactTable({
    data: filteredData,
    columns,
    getCoreRowModel: getCoreRowModel(),
    getSortedRowModel: getSortedRowModel(),
    getFilteredRowModel: getFilteredRowModel(),
    getPaginationRowModel: getPaginationRowModel(),
    initialState: { pagination: { pageSize: 10 } },
  });

  return {
    selectedRow,
    setSelectedRow,
    search,
    setSearch,
    statusFilter,
    setStatusFilter,
    discountTypeFilter,
    setDiscountTypeFilter,
    applicabilityFilter,
    setApplicabilityFilter,
    startDateFilter,
    setStartDateFilter,
    endDateFilter,
    setEndDateFilter,
    isClient,
    table,
  };
}