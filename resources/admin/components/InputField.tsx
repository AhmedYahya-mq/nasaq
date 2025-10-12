import InputError from "./input-error";
import { Input } from "./ui/input";
import { Label } from "./ui/label";

// --- Component for reusable input field ---
const InputField = ({ label, id, name, type = "text", required = false, defaultValue, description, errors }: any) => (
    <div className="grid gap-3">
        <Label htmlFor={id} className={required ? "required-label" : ""}>{label}</Label>
        <div className="flex flex-col gap-1">
            <Input id={id} name={name} type={type} defaultValue={defaultValue} required={required} />
            {description && <div className="text-sm text-muted-foreground">{description}</div>}
            <InputError message={errors?.[name]} />
        </div>
    </div>
);

export default InputField;