import { useState } from "react";
import { Input } from "./input";
import { Button } from "./button";
import { EyeClosedIcon, EyeIcon } from "lucide-react";

export default function InputPassword({ ...props }) {
    const [showPassword, setShowPassword] = useState(false);
    return (
        <div className="relative w-full">
            <Input
                type={showPassword ? "text" : "password"}
                {...props}
            />
            <Button
                variant="ghost"
                type="button"
                size="icon"
                className="absolute top-1/2 rtl:left-2 ltr:right-2 -translate-y-1/2 p-0"
                onClick={() => setShowPassword(!showPassword)}
                tabIndex={-1}
            >
                {showPassword ? (
                    <EyeClosedIcon className="size-4 *:stroke-primary" />
                ) : (
                    <EyeIcon className="size-4 *:stroke-primary" />
                )}
            </Button>
        </div>
    );
}