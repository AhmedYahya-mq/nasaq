import React, { useEffect, useRef } from "react";
import intlTelInput from "intl-tel-input";
import "intl-tel-input/build/css/intlTelInput.css";
import { Input } from "./input";
import { ar } from "intl-tel-input/i18n";

interface PhoneInputProps {
    defaultValue?: string;
    onChange?: (value: string) => void;
    defaultCountry?: string;
    name?: string;
    id?: string;
    className?: string;
    placeholder?: string;
    disabled?: boolean;
    required?: boolean;
}

const PhoneInput: React.FC<PhoneInputProps> = ({
    defaultValue = "",
    onChange,
    defaultCountry = "sa",
    name,
    id,
    className,
    placeholder,
    disabled,
    required,
}) => {
    const inputRef = useRef<HTMLInputElement>(null);
    const itiRef = useRef<any>(null);
    const [phoneNumber, setPhoneNumber] = React.useState(defaultValue);

    useEffect(() => {
        if (!inputRef.current) return;
        inputRef.current.dir = "rtl";
        itiRef.current = intlTelInput(inputRef.current, {
            initialCountry: defaultCountry,
            placeholderNumberType: "MOBILE",
            autoPlaceholder: "aggressive",
            nationalMode: false,
            i18n: ar,
            containerClass: "w-full",
            loadUtils: () => import("intl-tel-input/utils"),
        });

        const handleCountryChange = () => {
            if (onChange && itiRef.current) {
                onChange(itiRef.current.getNumber());

            }
            setPhoneNumber(itiRef.current.getNumber());
        };
        inputRef.current.addEventListener("countrychange", handleCountryChange);
        inputRef.current.addEventListener("input", handleCountryChange);

        return () => {
            inputRef.current?.removeEventListener("countrychange", handleCountryChange);
            itiRef.current?.destroy();
        };
    }, [defaultCountry, onChange]);

    useEffect(() => {
        if (itiRef.current && defaultValue) {
            itiRef.current.setNumber(defaultValue);
        }
    }, [defaultValue]);

    return (
        <Input
            dir="ltr"
            ref={inputRef}
            value={phoneNumber}
            type="tel"
            name={name}
            id={id}
            placeholder={placeholder || "أدخل رقم الهاتف"}
            disabled={disabled}
            required={required}
            autoComplete="tel"
            inputMode="tel"
            className={className}
            onChange={(e) => e.stopPropagation()}
        />
    );
};

export default PhoneInput;
