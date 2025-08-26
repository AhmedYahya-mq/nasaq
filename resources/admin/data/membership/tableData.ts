
import { Membership } from "@/types/membership";
// أعمدة الجدول
import { ColumnDef } from "@tanstack/react-table";



// إنشاء بيانات وهمية
export const memberships: Membership[] = Array.from({ length: 2000 }, (_, i) => ({
  id: i + 1,
  name: `Membership ${i + 1}`,
  description: `وصف العضوية رقم ${i + 1}`,
  price: Math.floor(Math.random() * 100) + 10, // سعر بين 10 و 109
}));


export const columns: ColumnDef<Membership>[] = [
  { accessorKey: "id", header: "ID" },
  { accessorKey: "name", header: "اسم العضوية" },
  { accessorKey: "description", header: "الوصف" },
  { accessorKey: "price", header: "السعر ($)" },
];

