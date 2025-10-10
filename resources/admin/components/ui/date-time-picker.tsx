import * as React from "react";
import { format } from "date-fns";
import { cn } from "@/lib/utils";
import { Button } from "@/components/ui/button";
import { Calendar } from "@/components/ui/calendar";
import {
  Popover,
  PopoverContent,
  PopoverTrigger,
} from "@/components/ui/popover";
import { CalendarIcon } from "lucide-react";

interface DateTimePickerProps {
  id?: string;
  name?: string;
  value?: Date;
  onChange?: (date: Date) => void;
  className?: string;
  disabled?: (date: Date) => boolean;
  required?: boolean;
}

export function DateTimePicker({
  id,
  name,
  value,
  onChange,
  className,
  disabled,
  required,
}: DateTimePickerProps) {
  const [date, setDate] = React.useState<Date>(value ?? new Date());
  const [isOpen, setIsOpen] = React.useState(false);

  const hours = React.useMemo(() => Array.from({ length: 12 }, (_, i) => i + 1), []);
  const minutes = React.useMemo(() => Array.from({ length: 60 }, (_, i) => i), []);

  const hourRefs = React.useRef<(HTMLButtonElement | null)[]>([]);
  const minuteRefs = React.useRef<(HTMLButtonElement | null)[]>([]);
  const ampmRefs = React.useRef<(HTMLButtonElement | null)[]>([]);

  // 🔥 تمرير تلقائي بعد فتح الـPopover
  React.useEffect(() => {
    if (!isOpen || !date) return;

    // ننتظر حتى تُرسم القوائم فعليًا
    const timeout = setTimeout(() => {
      const selectedHour = date.getHours() % 12 || 12;
      const selectedMinute = date.getMinutes();
      const isPM = date.getHours() >= 12;

      const hourBtn = hourRefs.current.find(
        (btn) => btn?.textContent === selectedHour.toString()
      );
      const minuteBtn = minuteRefs.current[selectedMinute];
      const ampmBtn = ampmRefs.current[isPM ? 1 : 0];

      hourBtn?.scrollIntoView({ block: "center", behavior: "auto" });
      minuteBtn?.scrollIntoView({ block: "center", behavior: "auto" });
      ampmBtn?.scrollIntoView({ block: "center", behavior: "auto" });
    }, 0);

    return () => clearTimeout(timeout);
  }, [isOpen, date]);

  const handleDateSelect = (selectedDate: Date | undefined) => {
    if (selectedDate) {
      const newDate = new Date(selectedDate);
      newDate.setHours(date.getHours());
      newDate.setMinutes(date.getMinutes());
      setDate(newDate);
      onChange?.(newDate);
    }
  };

  const handleTimeChange = (type: "hour" | "minute" | "ampm", value: string) => {
    if (!date) return;
    const newDate = new Date(date);

    if (type === "hour") {
      const currentIsPM = newDate.getHours() >= 12;
      newDate.setHours((parseInt(value) % 12) + (currentIsPM ? 12 : 0));
    } else if (type === "minute") {
      newDate.setMinutes(parseInt(value));
    } else if (type === "ampm") {
      const hours = newDate.getHours();
      if (value === "PM" && hours < 12) newDate.setHours(hours + 12);
      if (value === "AM" && hours >= 12) newDate.setHours(hours - 12);
    }

    setDate(newDate);
    onChange?.(newDate);
  };

  return (
    <div id={id} className={cn("w-full", className)}>
      <input
        type="hidden"
        name={name}
        value={date ? date.toISOString() : ""}
        readOnly
        required={required}
      />
      <Popover open={isOpen} onOpenChange={setIsOpen}>
        <PopoverTrigger asChild>
          <Button
            variant="outline"
            className={cn(
              "w-full justify-start text-left font-normal",
              !date && "text-muted-foreground"
            )}
          >
            <CalendarIcon className="mr-2 h-4 w-4" />
            {date ? format(date, "yyyy-MM-dd hh:mm aa") : "اختر التاريخ والوقت"}
          </Button>
        </PopoverTrigger>
        <PopoverContent className="w-auto p-0">
          <div className="sm:flex">
            <Calendar
              mode="single"
              selected={date}
              disabled={disabled}
              onSelect={handleDateSelect}
              required={required}
            />
            <div className="flex flex-col sm:flex-row sm:h-[300px]  divide-y sm:divide-y-0 sm:divide-x">
              {/* الساعات */}
              <div className="w-64 sm:w-auto scrollbar max-h-[300px]">
                <div className="flex sm:flex-col p-2">
                  {[...hours].reverse().map((hour, i) => (
                    <Button
                      ref={(el) => (hourRefs.current[i] = el)}
                      key={hour}
                      size="icon"
                      variant={
                        date && date.getHours() % 12 === hour % 12
                          ? "default"
                          : "ghost"
                      }
                      className="sm:w-full shrink-0 aspect-square"
                      onClick={() => handleTimeChange("hour", hour.toString())}
                    >
                      {hour}
                    </Button>
                  ))}
                </div>
              </div>

              {/* الدقائق */}
              <div className="w-64 sm:w-auto scrollbar max-h-[300px]">
                <div className="flex sm:flex-col p-2">
                  {minutes.map((minute, i) => (
                    <Button
                      ref={(el) => (minuteRefs.current[i] = el)}
                      key={minute}
                      size="icon"
                      variant={
                        date && date.getMinutes() === minute
                          ? "default"
                          : "ghost"
                      }
                      className="sm:w-full shrink-0 aspect-square"
                      onClick={() => handleTimeChange("minute", minute.toString())}
                    >
                      {minute}
                    </Button>
                  ))}
                </div>
              </div>

              {/* AM / PM */}
              <div className="scrollbar max-h-[300px]">
                <div className="flex sm:flex-col p-2">
                  {["AM", "PM"].map((ampm, i) => (
                    <Button
                      ref={(el) => (ampmRefs.current[i] = el)}
                      key={ampm}
                      size="icon"
                      variant={
                        date &&
                        ((ampm === "AM" && date.getHours() < 12) ||
                          (ampm === "PM" && date.getHours() >= 12))
                          ? "default"
                          : "ghost"
                      }
                      className="sm:w-full shrink-0 aspect-square"
                      onClick={() => handleTimeChange("ampm", ampm)}
                    >
                      {ampm}
                    </Button>
                  ))}
                </div>
              </div>
            </div>
          </div>
        </PopoverContent>
      </Popover>
    </div>
  );
}
