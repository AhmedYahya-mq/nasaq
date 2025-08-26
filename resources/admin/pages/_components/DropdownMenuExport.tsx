import { Button } from "@/components/ui/button";
import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuItem,
  DropdownMenuTrigger,
} from "@/components/ui/dropdown-menu";
import { FileTextIcon, FileSpreadsheetIcon, PrinterIcon, ChevronDownIcon, ShareIcon } from "lucide-react";

interface DropdownMenuExportProps {
  className?: string;
}

export default function DropdownMenuExport({ className }: DropdownMenuExportProps) {
  return (
    <DropdownMenu>
      <DropdownMenuTrigger asChild>
        <Button variant="outline" className={className}>
          <ShareIcon />
          Export
          <ChevronDownIcon className="size-4 opacity-50" />
        </Button>
      </DropdownMenuTrigger>
      <DropdownMenuContent>
        <DropdownMenuItem>
          <FileSpreadsheetIcon />
          Export as CSV
        </DropdownMenuItem>
        <DropdownMenuItem>
          <FileTextIcon />
          Export as Pdf
        </DropdownMenuItem>
        <DropdownMenuItem>
          <PrinterIcon />
          Export as Print
        </DropdownMenuItem>
      </DropdownMenuContent>
    </DropdownMenu>
  );
}
