import intlTelInput from "intl-tel-input";
import "intl-tel-input/build/css/intlTelInput.css";
import ar from "intl-tel-input/i18n/ar";

export default function phoneInput() {
    return {
        iti: null,
        number: "",
        isValid: true,
        error: "",
        utilsReady: false, // للتأكد إن utils.js جاهز
        init() {
            this.iti = intlTelInput(this.$refs.input, {
                initialCountry: "sa",
                preferredCountries: ["sa", "ae", "eg", "ye"],
                i18n: ar,
                containerClass: "w-full",
               loadUtils: () => import("intl-tel-input/utils"),
            });

            const validate = () => {
                this.number = this.iti.getNumber();

                // if (!this.utilsReady) {
                //     this.error = "جارِ التحقق...";
                //     this.isValid = false;
                //     return;
                // }

                this.isValid = this.iti.isValidNumberPrecise();
                console.log(`Is valid: ${this.isValid}`);

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

            // عند الكتابة
            this.$refs.input.addEventListener("input", () => {
                this.$refs.input.value = this.$refs.input.value.replace(/[^\d+]/g, '');
                validate();
            });

            // عند تغيير الدولة
            this.$refs.input.addEventListener("countrychange", validate);
        },
    };
}
