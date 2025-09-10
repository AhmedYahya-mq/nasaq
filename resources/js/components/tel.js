import intlTelInput from "intl-tel-input";
import "intl-tel-input/build/css/intlTelInput.css";
import ar from "intl-tel-input/i18n/ar";


export default function phoneInput(phone) {
    return {
        iti: null,
        number: phone || "",
        isValid: true,
        error: "",
        utilsReady: false, // للتأكد إن utils.js جاهز
        init() {
            this.iti = intlTelInput(this.$refs.input, {
                initialCountry: "sa",
                placeholderNumberType: "MOBILE",
                formatOnDisplay: true,
                nationalMode: false,
                autoHideDialCode: false,
                autoPlaceholder: "aggressive",
                preferredCountries: ["sa", "ae", "eg", "ye"],
                i18n: ar,
                containerClass: "w-full",
                loadUtils: () => import("intl-tel-input/utils"),
            });
            window.intlTelInput = this;
            if (this.number) {
                this.iti.setNumber(this.number);
            }
            const validate = () => {
                this.number = this.iti.getNumber(intlTelInput.utils.numberFormat.E164);

                this.isValid = this.iti.isValidNumberPrecise();
                if (!this.isValid) {
                    const errorMap = {
                        0: "رقم غير صالح",
                        1: "الرقم قصير جدًا",
                        2: "الرقم طويل جدًا",
                        3: "الرقم غير صالح للدولة",
                        4: "رقم غير صالح",
                    };
                    this.error = errorMap[this.iti.getValidationError()] || "رقم غير صحيح";
                } else {
                    this.error = "";
                }
            };

            this.$refs.input.addEventListener("input", () => {
                this.$refs.input.value = this.$refs.input.value.replace(/[^\d+]/g, '');
                validate();
            });
            // عند تغيير الدولة
            this.$refs.input.addEventListener("countrychange", validate);
        },
    };
}
