import { callback, create, coupon as couponRoute } from "@client/routes/client/pay";
import { translate } from "@client/utils/translate";
import axios from "axios";

export default function payForm(props = {}) {
    // ----- local Mada BINs sample (استخدم نفس القائمة Qn عندك) -----
    const MADA_BINS = new Set([
        "22337902", "22337986", "22402030", "40177800", "403024", "40545400", "406136", "406996",
        "40719700", "40728100", "40739500", "407520", "409201", "410621", "410685", "410834",
        "412565", "417633", "419593", "420132", "421141", "42222200", "422817", "422818", "422819",
        "428331", "428671", "428672", "428673", "431361", "432328", "434107", "439954", "440533",
        "440647", "440795", "442429", "442463", "445564", "446393", "446404", "446672", "45488707",
        "45501701", "455036", "455708", "457865", "457997", "458456", "462220", "468540", "468541",
        "468542", "468543", "474491", "483010", "483011", "483012", "484783", "486094", "486095",
        "486096", "489318", "489319", "49098000", "49098001", "492464", "504300", "513213", "515079",
        "516138", "520058", "521076", "52166100", "524130", "524514", "524940", "529415", "529741",
        "530060", "531196", "535825", "535989", "536023", "537767", "53973776", "543085", "543357",
        "549760", "554180", "555610", "558563", "588845", "588848", "588850", "604906", "636120",
        "968201", "968202", "968203", "968204", "968205", "968206", "968207", "968208", "968209",
        "968211", "968212"
    ]);

    // ----- helpers -----
    const asNumber = (value, fallback = 0) => {
        const num = Number(value);
        return Number.isFinite(num) ? num : fallback;
    };

    function onlyDigits(str = "") {
        return String(str || "").replace(/\D/g, "");
    }

    function extractBin(number, len = 6) {
        const d = onlyDigits(number);
        return d.length >= len ? d.slice(0, len) : null;
    }

    function luhnCheck(numStr) {
        const digits = onlyDigits(numStr);
        if (!digits) return false;
        let sum = 0;
        let alt = false;
        for (let i = digits.length - 1; i >= 0; i--) {
            let n = parseInt(digits[i], 10);
            if (alt) {
                n *= 2;
                if (n > 9) n -= 9;
            }
            sum += n;
            alt = !alt;
        }
        return sum % 10 === 0;
    }

    function detectBrand(number) {
        const num = onlyDigits(number);
        if (!num) return "";

        // Mada first (BIN6 or BIN8)
        const bin6 = num.slice(0, 6);
        const bin8 = num.slice(0, 8);
        if (MADA_BINS.has(bin6) || MADA_BINS.has(bin8)) return "mada";

        // MasterCard: 51-55
        if (/^5[1-5]/.test(num)) return "mastercard";

        // MasterCard: 2221-2720 (2-series)
        const prefix4 = parseInt(num.slice(0, 4), 10);
        if (!Number.isNaN(prefix4) && prefix4 >= 2221 && prefix4 <= 2720) return "mastercard";

        // Visa
        if (/^4/.test(num)) return "visa";

        return "unknown";
    }

    function validLengthForBrand(number, brand) {
        const len = onlyDigits(number).length;
        switch (brand) {
            case "visa":
                return [13, 16, 19].includes(len);
            case "mastercard":
                return len === 16;
            case "mada":
                return len === 16;
            default:
                return len >= 12 && len <= 19;
        }
    }

    function parseExpiry(value) {
        // supports: MMYY, MM/YY, MM / YY, MMYYYY, MM / YYYY
        const raw = onlyDigits(String(value || ""));
        if (!raw) return { ok: false };
        if (raw.length === 4) { // MMYY
            const mm = raw.slice(0, 2);
            const yy = raw.slice(2);
            return { ok: true, month: parseInt(mm, 10), year: 2000 + parseInt(yy, 10) };
        }
        if (raw.length === 6) { // MMYYYY
            return { ok: true, month: parseInt(raw.slice(0, 2), 10), year: parseInt(raw.slice(2), 10) };
        }
        return { ok: false };
    }

    function expiryIsFuture(month, year) {
        if (!month || !year) return false;
        if (month < 1 || month > 12) return false;
        const expDate = new Date(year, month, 0, 23, 59, 59, 999); // last day of month
        return expDate >= new Date();
    }

    function validateCvcByBrand(cvc, brand) {
        const d = onlyDigits(cvc || "");
        // No Amex support: require 3 digits for all supported brands
        return /^\d{3}$/.test(d);
    }

    function isEnglishName(value = "") {
        // Allow English letters and spaces only (no digits or Arabic letters)
        return /^[A-Za-z ]+$/.test(String(value).trim());
    }

    function formatCardNumber(raw, brand) {
        const digits = onlyDigits(raw);
        // No Amex formatting required
        const trimmed = digits.slice(0, 19);
        return trimmed.replace(/(\d{4})(?=\d)/g, "$1 ").trim();
    }

    const initialPrices = {
        base: asNumber(props?.prices?.base, 0),
        discount: asNumber(props?.prices?.discount, 0),
        membershipDiscount: asNumber(props?.prices?.membershipDiscount, 0),
        coupon: asNumber(props?.prices?.coupon, 0),
        total: asNumber(props?.prices?.total, 0),
    };

    // ----- main reactive object -----
    return {
        paymentMethod: "card",
        crsf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        basePricing: initialPrices,
        prices: { ...initialPrices },
        coupon: {
            code: props?.prices?.code ?? "",
            applied: false,
            applying: false,
            error: "",
            success: "",
        },
        card: {
            number: "",
            expiry: "",
            cvc: "",
            name: "",
            type: "",
            touched: {
                number: false,
                expiry: false,
                cvc: false,
                name: false,
            },
        },
        errors: {},
        stc: {
            phone: "",
            touched: {
                phone: false,
                otp: false,
            },
            otp: "",
            otpTimer: "05:00",
            otpSent: false,
            otpUrl: "",
        },

        stcError: "",
        otpError: "",
        cardFormValid: false,
        stcFormValid: false,
        onProgress: false,
        intervalId: null,

        init() {
            this.$watch("card", () => this.validateCardForm(), { deep: true });
            this.$watch("stc.phone", () => this.validateStcForm());
        },

        updatePrices(amounts = {}) {
            const basePrice = asNumber(amounts.base ?? amounts.base_price, this.basePricing.base);
            const discount = asNumber(amounts.discount ?? amounts.discount_amount, this.basePricing.discount);
            const membershipDiscount = asNumber(
                amounts.membership_discount ?? amounts.membershipDiscount,
                this.basePricing.membershipDiscount
            );
            const couponAmount = asNumber(amounts.coupon ?? amounts.coupon_amount, 0);
            const providedTotal = asNumber(amounts.total ?? amounts.final_price, null);
            const computedTotal = providedTotal !== null
                ? providedTotal
                : Math.max(0, basePrice - discount - membershipDiscount - couponAmount);

            this.prices = {
                base: basePrice,
                discount,
                membershipDiscount,
                coupon: couponAmount,
                total: computedTotal,
            };
        },

        applyCoupon() {
            this.coupon.error = "";
            this.coupon.success = "";
            const code = (this.coupon.code || "").trim();

            if (!code) {
                this.coupon.error = translate("Please enter a coupon code.");
                return;
            }

            this.coupon.applying = true;
            axios.post(couponRoute().url, { code, _token: this.crsf })
                .then((res) => {
                    if (res.data?.success) {
                        this.coupon.applied = true;
                        this.coupon.success = translate("Coupon applied successfully.");
                        this.updatePrices(res.data?.amounts || {});
                    } else {
                        this.coupon.applied = false;
                        this.coupon.error = translate(res.data?.message || "Unable to apply coupon.");
                        this.updatePrices({ ...this.basePricing, coupon: 0, total: this.basePricing.total });
                    }
                })
                .catch((err) => {
                    this.coupon.applied = false;
                    this.coupon.error = translate(
                        err.response?.data?.errors?.code?.[0] ||
                        err.response?.data?.message ||
                        "Invalid coupon."
                    );
                    this.updatePrices({ ...this.basePricing, coupon: 0, total: this.basePricing.total });
                })
                .finally(() => {
                    this.coupon.applying = false;
                });
        },

        removeCoupon() {
            this.coupon.code = "";
            this.coupon.applied = false;
            this.coupon.applying = false;
            this.coupon.error = "";
            this.coupon.success = "";
            this.updatePrices({ ...this.basePricing, coupon: 0, total: this.basePricing.total });
        },

        // ----- inputs handlers -----
        onCardNumberInput(e) {
            const raw = onlyDigits(e.target.value);
            const brand = detectBrand(raw);
            this.card.type = brand;
            this.card.number = formatCardNumber(raw, brand);
        },

        onExpiryInput(e) {
            const digits = onlyDigits(e.target.value).slice(0, 6);
            if (digits.length <= 2) {
                this.card.expiry = digits;
            } else if (digits.length <= 4) {
                this.card.expiry = digits.slice(0, 2) + " / " + digits.slice(2);
            } else {
                this.card.expiry = digits.slice(0, 2) + " / " + digits.slice(2);
            }
        },

        onCvcInput(e) {
            const raw = onlyDigits(e.target.value);
            const max = 3; // Amex removed => always 3
            this.card.cvc = raw.slice(0, max);
        },

        // ----- validation -----
        validateCardForm() {
            const errs = {};
            const rawNumber = onlyDigits(this.card.number);
            const brand = this.card.type || detectBrand(rawNumber);

            // number
            if (this.card.touched.number) {
                if (!rawNumber) {
                    errs.number = translate("Please enter the card number.");
                } else if (!validLengthForBrand(rawNumber, brand)) {
                    errs.number = translate("The card number length is incorrect for the card type.");
                } else if (!luhnCheck(rawNumber)) {
                    errs.number = translate("The card number is invalid.");
                }
            }

            // expiry
            if (this.card.touched.expiry) {
                if (!this.card.expiry) {
                    errs.expiry = translate("Please enter the expiry date.");
                } else {
                    const parsed = parseExpiry(this.card.expiry);
                    if (!parsed.ok) {
                        errs.expiry = translate("Invalid format (MM / YY).");
                    } else if (!expiryIsFuture(parsed.month, parsed.year)) {
                        errs.expiry = translate("The card has expired.");
                    }
                }
            }

            // cvc
            if (this.card.touched.cvc) {
                if (!this.card.cvc) {
                    errs.cvc = translate("Please enter the CVC code.");
                } else if (!validateCvcByBrand(this.card.cvc, brand)) {
                    errs.cvc = translate("The CVC code is invalid.");
                }
            }

            // name
            if (this.card.touched.name) {
                if (!this.card.name || !this.card.name.trim()) {
                    errs.name = translate("Please enter the cardholder name.");
                }
                else if (!isEnglishName(this.card.name)) {
                    errs.name = translate("Cardholder name must be English letters only.");
                }
            }

            // block unsupported brands
            if (rawNumber && brand === "unknown") {
                errs.number = translate("The card type is not supported.");
            }

            this.errors = errs;
            this.cardFormValid = Object.keys(errs).length === 0;
        },

        validateStcForm() {
            this.stcError = "";
            if (this.stc.touched) {
                if (!this.stc.phone) this.stcError = translate("Please enter your phone number.");
                else if (!/^05\d{8}$/.test(this.stc.phone)) this.stcError = translate("The phone number must start with 05 and be 10 digits.");
            }
            this.stcFormValid = !this.stcError;
        },

        validOtpForm() {
            this.otpError = "";
            if (this.stc.touched.otp) {
                if (!this.stc.otp) this.otpError = translate("Please enter the verification code.");
                else if (!/^\d{4,6}$/.test(this.stc.otp)) this.otpError = translate("The verification code must be between 4 and 6 digits.");
            }
            return !this.otpError;
        },

        startOtpTimer() {
            let totalSeconds = 5 * 60; // 5 دقائق
            this.stc.otpTimer = "05:00";
            this.intervalId = setInterval(() => {
                totalSeconds--;
                const minutes = Math.floor(totalSeconds / 60);
                const seconds = totalSeconds % 60;
                this.stc.otpTimer = `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
                if (totalSeconds <= 0) {
                    clearInterval(this.intervalId);
                    this.stc.otpSent = false;
                    this.stc.otpTimer = "05:00";
                    this.stc.otpUrl = "";
                }
            }, 1000);
        },

        // ----- submit -----
        async submitCard() {
            Object.keys(this.card.touched).forEach((k) => (this.card.touched[k] = true));
            this.validateCardForm();
            if (!this.cardFormValid) return;

            const payload = {
                cc_number: onlyDigits(this.card.number),
                cc_expiry: this.card.expiry,
                cvc: this.card.cvc,
                name: this.card.name,
                cc_type: "creditcard",
                _token: this.crsf,
                coupon_code: this.coupon.code ? this.coupon.code.trim().toUpperCase() : undefined,
            };

            this.onProgress = true;
            try {
                const res = await axios.post(create().url, payload);
                if (res.data && res.data.success) {
                    const data = res.data;
                    if (data.status !== 'failed') {
                        window.location.href = res.data.transaction_url || "/";
                    }
                    else {
                        this.errors.form = translate(data.message || "Payment failed. Please try again.");
                    }
                }
                else {
                    this.errors.form = translate(res.data.message || "An unexpected error occurred, please try again.");
                }
            } catch (err) {
                console.error("Error submitting card data:", err.response?.data || err.message || err);
                if (err.response?.data?.errors) {
                    this.errors = {
                        ...this.errors,
                        name: err.response.data.errors.name?.[0] ? translate(err.response.data.errors.name?.[0]) : undefined,
                        number: err.response.data.errors.cc_number?.[0] ? translate(err.response.data.errors.cc_number?.[0]) : undefined,
                        expiry: err.response.data.errors.cc_expiry?.[0] ? translate(err.response.data.errors.cc_expiry?.[0]) : '',
                        cvc: err.response.data.errors.cvc?.[0] ? translate(err.response.data.errors.cvc?.[0]) : undefined,
                        month: err.response.data.errors.cc_exp_month?.[0] ? translate(err.response.data.errors.cc_exp_month?.[0]) : undefined,
                        year: err.response.data.errors.cc_exp_year?.[0] ? translate(err.response.data.errors.cc_exp_year?.[0]) : undefined,
                        type: err.response.data.errors.cc_type?.[0] ? translate(err.response.data.errors.cc_type?.[0]) : undefined,
                    };
                    this.cardFormValid = false;
                } else {
                    this.errors.form = translate(err.response?.data?.message || "An unexpected error occurred, please try again.");
                }
            } finally {
                this.onProgress = false;
            }
        },

        submitStc() {
            this.stcError = "";
            if (this.stc.otpSent && this.stc.otpUrl) {
                this.sendOtp();
            } else {
                this.sendPhoneVerification();
            }
        },

        sendPhoneVerification() {
            this.validateStcForm();
            if (!this.stcFormValid) return;
            this.onProgress = true;
            const payload = {
                phone: this.stc.phone,
                cc_type: "stcpay",
                _token: this.crsf,
                coupon_code: this.coupon.code ? this.coupon.code.trim().toUpperCase() : undefined,
            };
            axios.post(create().url, payload).then((res) => {
                if (res.data && res.data.success && res.data.status !== 'failed') {
                    this.stc.otpSent = true;
                    this.stc.otpUrl = res.data.transaction_url || "";
                    this.startOtpTimer();
                } else {
                    this.stcError = translate(res.data.message || "An unexpected error occurred, please try again.");
                }
            }).catch((err) => {
                this.stcError = translate(err.response?.data?.errors?.phone?.[0] || err.response?.data?.message || "An unexpected error occurred, please try again.");
            }).finally(() => {
                this.onProgress = false;
            });
        },

        sendOtp() {
            if (!this.validOtpForm()) return;
            this.onProgress = true;
            axios.get(this.stc.otpUrl + "&otp_value=" + this.stc.otp).then((res) => {
                if (res.data && res.data.status !== 'failed') {
                    window.location.href = callback().url + "?id=" + res.data.id + "&status=" + res.data.status + "&message=" + encodeURIComponent(res.data.source?.message || "");
                } else {
                    this.onProgress = false;
                    this.stcError = translate(res.data.message || res.data.source?.message || "Verification failed. Please try again.");
                }
            }).catch((err) => {
                this.onProgress = false;
                this.stcError = translate(err.response?.data?.message || err.response?.data?.source?.message || "An unexpected error occurred, please try again.");
            }).finally(() => {
                clearInterval(this.intervalId);
                this.stc.otp = "";
                this.stc.otpSent = false;
                this.stc.otpTimer = "05:00";
                this.stc.otpUrl = "";
            });
        },
    }
}
