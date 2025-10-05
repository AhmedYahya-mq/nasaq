import { Switch } from "@/components/ui/switch";
import { TableCell } from "@/components/ui/table";
import { useState } from "react";

export const SwitchCell =
  (onChange: (item: any) => Promise<boolean>) =>
  ({ row, getValue }: any) => {
    const item = row.original;
    const value = Boolean(getValue()); // القيمة الحالية
    const [checked, setChecked] = useState<boolean>(value);

    return (
      <TableCell dir="ltr" className="text-center">
        <Switch
        dir="ltr"
          checked={checked}
          onCheckedChange={async () => {
            const result = await onChange(item);
            // ما نغير إلا لو القيمة فعلاً اختلفت
            if (result !== checked) {
              setChecked(result);
            }
          }}
        />
      </TableCell>
    );
  };
