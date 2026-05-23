import { translate } from "@client/utils/translate";
import axios from "axios";

export default function payForm(options = {}) {
    const initialPrices = options?.prices ?? {};
    const applePayOptions = options?.applePay ?? {};
    const prices = {
        base: Number(initialPrices.base ?? 0),
        discount: Number(initialPrices.discount ?? 0),
        membershipDiscount: Number(initialPrices.membershipDiscount ?? 0),
        total: Number(initialPrices.total ?? 0),
    };
    const backendBaseUrl = String(options?.backendBaseUrl ?? "").trim().replace(/\/$/, "");

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
    function onlyDigits(str = "") {
        return String(str || "").replace(/\D/g, "");
    }

    function getIntentToken() {
        const provided = String(options?.intentToken || "").trim();
        if (provided) return provided;

        const fromDom = document.getElementById("payment_intent_token")?.value;
        const token = String(fromDom || "").trim();
        return token || null;
    }

    function getLocalePrefix() {
        const first = window.location.pathname.split("/").filter(Boolean)[0] || "";
        return first === "ar" || first === "en" ? `/${first}` : "";
    }

    function paymentCreateUrl() {
        return `${backendBaseUrl}${getLocalePrefix()}/payment/create`;
    }

    function paymentCallbackUrl() {
        return `${backendBaseUrl}${getLocalePrefix()}/payment/callback`;
    }

    function normalizeAxiosErrorMessage(err) {
        return (
            err?.response?.data?.message ||
            err?.response?.data?.source?.message ||
            err?.message ||
            "An unexpected error occurred, please try again."
        );
    }

    function firstError(errorsObj, key) {
        const v = errorsObj?.[key];
        return Array.isArray(v) ? v[0] : undefined;
    }

    function applyServerValidationErrors(errorsObj) {
        if (!errorsObj) return false;
        this.errors = {
            ...this.errors,
            form: this.errors.form,
            name: firstError(errorsObj, "name") ? translate(firstError(errorsObj, "name")) : this.errors.name,
            number: firstError(errorsObj, "cc_number") ? translate(firstError(errorsObj, "cc_number")) : this.errors.number,
            expiry: firstError(errorsObj, "cc_expiry") ? translate(firstError(errorsObj, "cc_expiry")) : this.errors.expiry,
            cvc: firstError(errorsObj, "cvc") ? translate(firstError(errorsObj, "cvc")) : this.errors.cvc,
            month: firstError(errorsObj, "cc_exp_month") ? translate(firstError(errorsObj, "cc_exp_month")) : this.errors.month,
            year: firstError(errorsObj, "cc_exp_year") ? translate(firstError(errorsObj, "cc_exp_year")) : this.errors.year,
            type: firstError(errorsObj, "cc_type") ? translate(firstError(errorsObj, "cc_type")) : this.errors.type,
            applepay: firstError(errorsObj, "applepay_token") ? translate(firstError(errorsObj, "applepay_token")) : this.errors.applepay,
        };
        return true;
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

    function maxLengthForBrand(brand) {
        switch (brand) {
            case "mastercard":
            case "mada":
                return 16;
            case "visa":
                return 16;
            default:
                return 16;
        }
    }

    function formatCardNumber(rawDigits) {
        const digits = onlyDigits(rawDigits);
        return digits.replace(/(\d{4})(?=\d)/g, "$1 ").trim();
    }

    // ----- main reactive object -----
    return {
        prices,
        paymentMethod: "card",
        csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
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
        applePay: {
            available: false,
            error: "",
        },
        cardFormValid: false,
        stcFormValid: false,
        onProgress: false,
        intervalId: null,

        init() {
            this.$watch("card", () => this.validateCardForm(), { deep: true });
            this.$watch("stc.phone", () => this.validateStcForm());
            // Defer detection so the Apple Pay SDK has time to finish any async
            // internal setup (e.g. communicating with the OS on Chrome/macOS).
            this.$nextTick(() => this.detectApplePayAvailability());
        },

        // ----- inputs handlers -----
        onCardNumberInput(e) {
            const rawDigits = onlyDigits(e.target.value);

            // Detect brand early (BIN-based for Mada)
            const detected = detectBrand(rawDigits);
            const maxLen = maxLengthForBrand(detected);
            const trimmedDigits = rawDigits.slice(0, maxLen);

            // Re-detect after trimming for stability
            const brand = detectBrand(trimmedDigits);
            this.card.type = brand;
            this.card.number = formatCardNumber(trimmedDigits);
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
            const phoneDigits = onlyDigits(this.stc.phone);

            if (this.stc.touched.phone) {
                if (!phoneDigits) this.stcError = translate("Please enter your phone number.");
                else if (!/^05\d{8}$/.test(phoneDigits)) this.stcError = translate("The phone number must start with 05 and be 10 digits.");
            }

            this.stcFormValid = !this.stcError;
        },

        validOtpForm() {
            this.otpError = "";
            if (this.stc.touched.otp) {
                const otpDigits = onlyDigits(this.stc.otp);
                if (!otpDigits) this.otpError = translate("Please enter the verification code.");
                else if (!/^\d{4,6}$/.test(otpDigits)) this.otpError = translate("The verification code must be between 4 and 6 digits.");
            }
            return !this.otpError;
        },

        startOtpTimer() {
            if (this.intervalId) {
                clearInterval(this.intervalId);
                this.intervalId = null;
            }
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
            if (this.onProgress) return;

            Object.keys(this.card.touched).forEach((k) => (this.card.touched[k] = true));
            this.validateCardForm();
            if (!this.cardFormValid) return;

            const intentToken = getIntentToken();
            if (!intentToken) {
                this.errors = { ...this.errors, form: translate("Missing payment token. Please refresh the page.") };
                return;
            }

            const payload = {
                intent_token: intentToken,
                cc_number: onlyDigits(this.card.number),
                cc_expiry: this.card.expiry,
                cvc: onlyDigits(this.card.cvc),
                name: this.card.name,
                cc_type: "creditcard",
                _token: this.csrf,
            };

            this.onProgress = true;
            try {
                const res = await axios.post(paymentCreateUrl(), payload);
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
                const handledValidation = applyServerValidationErrors.call(this, err.response?.data?.errors);
                if (!handledValidation) this.errors.form = translate(normalizeAxiosErrorMessage(err));
            } finally {
                this.onProgress = false;
            }
        },

        async submitStc() {
            if (this.onProgress) return;

            this.stcError = "";

            if (this.stc.otpSent) {
                this.stc.touched.otp = true;
                return this.sendOtp();
            }

            this.stc.touched.phone = true;
            return this.sendPhoneVerification();
        },

        async sendPhoneVerification() {
            this.validateStcForm();
            if (!this.stcFormValid) return;

            const intentToken = getIntentToken();
            if (!intentToken) {
                this.stcError = translate("Missing payment token. Please refresh the page.");
                return;
            }

            this.onProgress = true;
            try {
                const payload = {
                    intent_token: intentToken,
                    phone: onlyDigits(this.stc.phone),
                    cc_type: "stcpay",
                    _token: this.csrf,
                };

                const res = await axios.post(paymentCreateUrl(), payload);
                const data = res?.data;

                if (data && data.success && data.status !== "failed") {
                    const url = String(data.transaction_url || "").trim();
                    if (!url) {
                        this.stcError = translate("An unexpected error occurred, please try again.");
                        return;
                    }

                    this.stc.otpSent = true;
                    this.stc.otpUrl = url;
                    this.startOtpTimer();
                } else {
                    this.stcError = translate(data?.message || "An unexpected error occurred, please try again.");
                }
            } catch (err) {
                const phoneError = firstError(err?.response?.data?.errors, "phone");
                this.stcError = translate(phoneError || normalizeAxiosErrorMessage(err));
            } finally {
                this.onProgress = false;
            }
        },

        async sendOtp() {
            if (!this.validOtpForm()) return;

            const otpUrl = String(this.stc.otpUrl || "").trim();
            if (!otpUrl) {
                this.stcError = translate("An unexpected error occurred, please try again.");
                return;
            }

            this.onProgress = true;
            try {
                const otpDigits = onlyDigits(this.stc.otp);
                const res = await axios.get(otpUrl + "&otp_value=" + otpDigits);
                const data = res?.data;

                if (data && data.status !== "failed") {
                    const message = encodeURIComponent(data.source?.message || "");
                    window.location.href = paymentCallbackUrl() + "?id=" + data.id + "&message=" + message;
                    return;
                }

                this.stcError = translate(data?.message || data?.source?.message || "Verification failed. Please try again.");
            } catch (err) {
                this.stcError = translate(normalizeAxiosErrorMessage(err));
            } finally {
                this.onProgress = false;
                if (this.intervalId) {
                    clearInterval(this.intervalId);
                    this.intervalId = null;
                }
                this.stc.otp = "";
                this.stc.otpSent = false;
                this.stc.otpTimer = "05:00";
                this.stc.otpUrl = "";
            }
        },

        detectApplePayAvailability() {
            try {
                this.applePay.error = "";

                const aps = window.ApplePaySession;

                if (!aps || typeof aps.supportsVersion !== "function") {
                    this.applePay.available = false;
                    console.log("Apple Pay JS API not available in this browser.");
                    return;
                }

                // Check if the browser supports at least Apple Pay version 3 (recommended baseline)
                const supportsApplePay = aps.supportsVersion(3);

                // Basic device/browser capability check (does NOT require a card in Wallet)
                const canMakePayments = aps.canMakePayments();

                this.applePay.available = supportsApplePay && canMakePayments;

                console.log("Apple Pay detection:", {
                    supportsVersion3: supportsApplePay,
                    canMakePayments: canMakePayments,
                    available: this.applePay.available
                });

            } catch (error) {
                this.applePay.available = false;
                this.applePay.error = error.message || "Unknown error detecting Apple Pay";
                console.error("Apple Pay availability check failed:", error);
            }
        },

        

        async submitApplePay() {
            if (this.onProgress) return;

            this.applePay.error = "";
            console.log("Starting Apple Pay flow...");
            console.log("Apple Pay availability:", this.applePay.available,window.ApplePaySession);
            if (!this.applePay.available || !window.ApplePaySession) {
                this.applePay.error = translate("Apple Pay not available on this device/browser.");
                return;
            }

            const intentToken = getIntentToken();
            if (!intentToken) {
                this.applePay.error = translate("Missing payment token. Please refresh the page.");
                return;
            }

            const paymentRequest = {
                countryCode: String(applePayOptions.countryCode || "SA"),
                currencyCode: String(applePayOptions.currencyCode || "SAR"),
                supportedNetworks: ["mada", "visa", "masterCard"],
                merchantCapabilities: ["supports3DS", "supportsCredit", "supportsDebit"],
                total: {
                    label: String(options?.itemLabel || applePayOptions.merchantName || "Order"),
                    amount: Number(prices.total || 0).toFixed(2),
                },
            };

            let session;
            try {
                session = new window.ApplePaySession(5, paymentRequest);
            } catch (error) {
                this.applePay.error = translate("Apple Pay not available on this device/browser.");
                return;
            }

            session.onvalidatemerchant = async (event) => {
                try {
                    const res = await fetch(`${applePayOptions.apiBaseUrl || "https://api.moyasar.com/v1"}/applepay/initiate`, {
                        method: "POST",
                        headers: { "Content-Type": "application/json" },
                        body: JSON.stringify({
                            validation_url: event.validationURL,
                            display_name: String(applePayOptions.merchantName || "Merchant"),
                            domain_name: window.location.hostname,
                            publishable_api_key: String(applePayOptions.publishableKey || ""),
                        }),
                    });

                    if (!res.ok) {
                        const bodyText = await res.text();
                        throw new Error(bodyText || `Merchant validation failed (${res.status})`);
                    }

                    let merchantSession;
                    try {
                        merchantSession = await res.json();
                    } catch (e) {
                        throw new Error("Invalid merchant session response from Moyasar.");
                    }

                    session.completeMerchantValidation(merchantSession);
                } catch (error) {
                    this.applePay.error = String(error?.message || normalizeAxiosErrorMessage(error));
                    session.abort();
                }
            };

            session.onpaymentauthorized = async (event) => {
                this.onProgress = true;

                try {
                    const payload = {
                        intent_token: intentToken,
                        cc_type: "applepay",
                        applepay_token: event.payment.token,
                        _token: this.csrf,
                    };

                    const res = await axios.post(paymentCreateUrl(), payload);
                    const data = res?.data;

                    if (!data?.success) {
                        throw new Error(data?.message || "Payment failed. Please try again.");
                    }

                    session.completePayment({ status: window.ApplePaySession.STATUS_SUCCESS });

                    const callbackPaymentId = String(data?.moyasar_id || data?.id || "").trim();
                    if (callbackPaymentId) {
                        window.location.href = `${paymentCallbackUrl()}?id=${encodeURIComponent(callbackPaymentId)}`;
                        return;
                    }

                    if (data?.transaction_url) {
                        window.location.href = data.transaction_url;
                        return;
                    }

                    window.location.href = "/";
                } catch (error) {
                    const handledValidation = applyServerValidationErrors.call(this, error?.response?.data?.errors);
                    if (!handledValidation) {
                        this.applePay.error = translate(normalizeAxiosErrorMessage(error));
                    }
                    session.completePayment({ status: window.ApplePaySession.STATUS_FAILURE });
                } finally {
                    this.onProgress = false;
                }
            };

            session.oncancel = () => {
                this.onProgress = false;
            };

            session.begin();
        },
    }
}
