import { Button } from "@/components/ui/button";
import {
  Tooltip,
  TooltipContent,
  TooltipTrigger,
  TooltipProvider, // أضفنا Provider للتحكم العام
} from "@/components/ui/tooltip";
import { Undo2, Redo2 } from "lucide-react";
import { Editor } from "@tiptap/core";

type UndoRedoControlsProps = { editor?: Editor  | null };

export default function UndoRedoControls({ editor }: UndoRedoControlsProps) {
  return (
    <TooltipProvider delayDuration={1000}> {/* تأخير 500 مللي ثانية */}
      <div className="flex items-center gap-1">
        <Tooltip >
          <TooltipTrigger asChild>
            <Button
              variant="ghost"
              type="button"
              size="icon"
              onClick={() => editor?.chain().focus().undo().run()}
              disabled={!editor?.can?.().undo?.()}
              className="h-8 w-8"
            >
              <Undo2 className="h-4 w-4" />
              <span className="sr-only">تراجع (Ctrl+Z)</span>
            </Button>
          </TooltipTrigger>
          <TooltipContent side="bottom">
            <div>تراجع (Ctrl+Z)</div>
          </TooltipContent>
        </Tooltip>

        <Tooltip>
          <TooltipTrigger asChild>
            <Button
              variant="ghost"
              size="icon"
              type="button"
              onClick={() => editor?.chain().focus().redo().run()}
              disabled={!editor?.can?.().redo?.()}
              className="h-8 w-8"
            >
              <Redo2 className="h-4 w-4" />
              <span className="sr-only">إعادة (Ctrl+Y)</span>
            </Button>
          </TooltipTrigger>
          <TooltipContent side="bottom">
            <div>إعادة (Ctrl+Y)</div>
          </TooltipContent>
        </Tooltip>
      </div>
    </TooltipProvider>
  );
}

export const UndoRedoButton = ({ editor }: { editor: Editor | null }) => {
  return <UndoRedoControls editor={editor} />;
};
