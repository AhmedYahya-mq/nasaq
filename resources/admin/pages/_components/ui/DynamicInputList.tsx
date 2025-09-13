import InputError from "@/components/input-error";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";

export default function DynamicInputList({
    label,
    name,
    count,
    setCount,
    values,
    errors,
    isTranslate,
}: {
    label: string;
    name: string;
    count: number;
    setCount: (n: number) => void;
    values?: string[];
    errors: Record<string, string>;
    isTranslate: boolean;
}) {
    return (
        <div className="grid gap-3">
            <Label className="required-label">{label}</Label>
            <div className="space-y-2">
                {Array.from({ length: count }).map((_, index) => (
                    <div className="relative" key={index}>
                        <Input
                            type="text"
                            placeholder={`${label} رقم ${index + 1}`}
                            name={`${name}[${index}]`}
                            required
                            defaultValue={values?.[index] ?? ""}
                        />
                        <InputError message={errors[`${name}.${index}`]} />
                        {count > 1 && !isTranslate && (
                            <Button
                                type="button"
                                variant="outline"
                                size="icon"
                                className="absolute !bg-transparent !border-none top-[18px] -translate-y-1/2 left-0.5 cursor-pointer"
                                onClick={() => setCount(count - 1)}
                            >
                                &times;
                            </Button>
                        )}
                    </div>
                ))}
                {!isTranslate && (
                    <Button
                        type="button"
                        variant="outline"
                        size="sm"
                        onClick={() => setCount(count + 1)}
                    >
                        إضافة
                    </Button>
                )}
            </div>
            <InputError message={errors[name]} />
        </div>
    );
}
