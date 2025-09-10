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

export function useTablePromotions({ promotions, columns }) {
  const [selectedRow, setSelectedRow] = useState(null);
  const [search, setSearch] = useState("");
  const [statusFilter, setStatusFilter] = useState(null);
  const [discountTypeFilter, setDiscountTypeFilter] = useState(null);
  const [applicabilityFilter, setApplicabilityFilter] = useState(null);
  const [startDateFilter, setStartDateFilter] = useState(null);
  const [endDateFilter, setEndDateFilter] = useState(null);
  const [isClient, setIsClient] = useState(false);

  useEffect(() => {
    setIsClient(true);
  }, []);

  // تحسين البحث باستخدام useCallback
  const matchesSearch = useCallback((promotion, searchTerm) => {
    if (!searchTerm) return true;
    const searchLower = searchTerm.toLowerCase();
    return (
      promotion.title.toLowerCase().includes(searchLower) ||
      promotion.description.toLowerCase().includes(searchLower) ||
      promotion.discountValue.toLowerCase().includes(searchLower) ||
      (promotion.applicability && promotion.applicability.toLowerCase().includes(searchLower))
    );
  }, []);

  // تحسين تصفية التاريخ
  const matchesDateRange = useCallback((promotionStartDate, promotionEndDate, filterStart, filterEnd) => {
    return (
      (!filterStart || filterStart <= promotionEndDate) &&
      (!filterEnd || filterEnd >= promotionStartDate)
    );
  }, []);

  // تحسين كبير في تصفية البيانات
  const filteredData = useMemo(() => {
    console.log(statusFilter, discountTypeFilter, applicabilityFilter, startDateFilter, endDateFilter);
    
    if (!promotions || promotions.length === 0) return [];
    if (!search && !statusFilter && !discountTypeFilter && 
        !applicabilityFilter && !startDateFilter && !endDateFilter) {
      return promotions;
    }

    const startFilterDate = startDateFilter ? parseDate(startDateFilter) : null;
    const endFilterDate = endDateFilter ? parseDate(endDateFilter) : null;

    return promotions.filter((promotion) => {
      const promotionStart = parseDate(promotion.startDate);
      const promotionEnd = parseDate(promotion.endDate);
      return (
        matchesSearch(promotion, search) &&
        (!statusFilter || promotion.isActive === statusFilter) &&
        (!discountTypeFilter || promotion.discountType === discountTypeFilter) &&
        (!applicabilityFilter || promotion.applicability === applicabilityFilter) &&
        matchesDateRange(promotionStart, promotionEnd, startFilterDate, endFilterDate)
      );
    });
  }, [promotions, search, statusFilter, discountTypeFilter, applicabilityFilter, 
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