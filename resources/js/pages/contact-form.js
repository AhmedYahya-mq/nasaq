
import { sendMail } from "@client/routes/client/contact";
import axios from "axios";

function contactForm() {
    return {
        formData: {
            name: '',
            email: '',
            phone: '',
            subject: '',
            message: ''
        },
        errors: {},
        loading: false,
        success: false,
        messageError: '',
        messageSuccess: 'تم إرسال رسالتك بنجاح. سنرد عليك في أقرب وقت ممكن.',

        async submitForm() {
            this.errors = {};
            this.messageError = '';
            if (this.loading) return;
            this.loading = true;

            try {
                const response = await axios({
                    method: sendMail().method,
                    url: sendMail().url,
                    data: this.formData
                });

                // نجاح الإرسال
                if (response.data.message) {
                    this.success = true;
                    this.messageError = '';
                    this.messageSuccess = response.data.message;
                    this.formData = {
                        name: '',
                        email: '',
                        phone: '',
                        subject: '',
                        message: ''
                    };
                    setTimeout(() => this.success = false, 5000);
                }else{
                    this.messageError = 'حدث خطأ غير متوقع. حاول مرة أخرى لاحقاً.';
                }

            } catch (error) {
                if (error.response && error.response.status === 422) {
                    this.errors = error.response.data.errors; // عرض الأخطاء من Laravel
                } else {
                    console.error('An unexpected error occurred:', error);
                    this.messageError = 'حدث خطأ غير متوقع. حاول مرة أخرى لاحقاً.';
                }
            } finally {
                this.loading = false;
            }
        }
    }
}

document.addEventListener('alpine:init', () => {
    Alpine.data('contactForm', contactForm);
});
