import axios from 'axios';
import { formatDate } from '../utils/date';
import { compressToWebP } from '../utils/compress';
import { update } from '@client/routes/client/profile/photo';
import { update as profileUpdate } from '@client/routes/user-profile-information';
import { send } from '@client/routes/verification';
import { confirmPassword, strongPassword } from '@client/utils/validtion';
import userPassword from '@client/routes/user-password';
import { confirm, disable, enable, qrCode, recoveryCodes, regenerateRecoveryCodes, secretKey } from '@client/routes/client/two-factor';
import { modelStore } from '@client/stores/model';

document.addEventListener('alpine:init', function () {
    window.Alpine.data('profileForm', profileForm);
    window.Alpine.data('photoProfile', photoProfile);
    window.Alpine.data('passwordChange', passwordChange);
    window.Alpine.data('twoFactorAuth', twoFactorAuth);
    modelStore(window.Alpine);
});



function profileForm(user = null) {
    return {
        form: {},
        original: {},
        disabled: false,
        saved: false,
        errors: {},
        isVerificationRequired: false,
        isSendEmail: false,
        isErrorSendEmail: false,
        loading: false,
        textSendEmail: 'إرسال رابط التحقق',
        init() {
            if (!user) {
                console.error('User data is required to initialize the form.');
                return;
            }
            this.form = {
                name: user.name || '',
                email: user.email || '',
                phone: user.phone || '',
                address: user.address || '',
                birthday: user.birthday ? formatDate(user.birthday, 'DD-MM-YYYY') : null,
                job_title: user.job_title || '',
                bio: user.bio || '',
            };
            this.isVerificationRequired = user.email_verified_at === null;
            this.textSendEmail = this.isVerificationRequired ? 'إرسال رابط التحقق' : 'إعادة إرسال رابط التحقق';
            this.original = { ...this.form };
        },
        reset() {
            this.form = { ...this.original };
            window.intlTelInput.number = this.form.phone || '';
        },
        updateField(key, value) {
            this.form[key] = value;
        },
        submit() {
            if (this.disabled) return;
            if (JSON.stringify(this.form) === JSON.stringify(this.original)) {
                console.error('No changes detected, skipping update.');
                return;
            }
            this.disabled = true;
            axios.request({
                method: profileUpdate().method,
                url: profileUpdate().url,
                data: this.form,
                withCredentials: true,
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
            }).then(response => {
                this.isVerificationRequired = this.original.email !== this.form.email;
                this.isSendEmail = this.isVerificationRequired;
                if (this.isSendEmail) {
                    setTimeout(() => {
                        this.isSendEmail = false;
                    }, 5000);
                }
                this.original = { ...this.form };
                this.saved = true;
                this.errors = {};
            }).catch(error => {
                this.errors = error.response?.data?.errors || {};
                console.error('Error updating profile:', this.errors);
            }).finally(() => {
                this.disabled = false;
                setTimeout(() => this.saved = false, 2000);
            });
        },

        sendVerification() {
            if (this.loading) return;
            this.loading = true;
            axios.request({
                ...send(),
                withCredentials: true,
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
            }).then(response => {
                this.isSendEmail = true;
                this.isErrorSendEmail = false;
            }).catch(error => {
                console.error('Error sending verification email:', error);
                this.isErrorSendEmail = true;
                this.isSendEmail = false;
            }).finally(() => {
                this.loading = false;
                this.textSendEmail = 'إعادة إرسال رابط التحقق';
                setTimeout(() => {
                    this.isSendEmail = false;
                    this.isErrorSendEmail = false;
                }, 5000);
            });
        }
    };
}

function photoProfile() {
    return {
        percent: "0%",
        loading: false,
        async updateFile(event) {
            if (!event.target.files || event.target.files.length === 0) {
                return;
            }
            const progressDiv = this.$refs.progres;
            const self = this;
            const formData = new FormData();
            self.loading = true;
            const webpFile = await compressToWebP(event.target.files[0]);
            formData.append('photo', webpFile, 'profile.webp');
            await axios.request({
                method: update().method,
                url: update().url,
                data: formData,
                withCredentials: true,
                headers: {
                    'Content-Type': 'multipart/form-data',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
                onUploadProgress: function (progressEvent) {
                    if (progressEvent.lengthComputable) {
                        let percentCompleted = ((progressEvent.loaded * 100) / progressEvent.total).toFixed(1);
                        self.percent = percentCompleted + "%";
                        console.log(self.percent);

                        progressDiv.style.background =
                            `conic-gradient(var(--primary) 0% ${percentCompleted}%, var(--background) ${percentCompleted}% 100%)`;
                    }
                }
            }).then(response => {
                this.changeSrc(response.data);
            }).catch(error => {

                console.error('Error uploading photo:', error);
            }).finally(() => {
                self.percent = "0%";
                progressDiv.style.background =
                    `conic-gradient(var(--primary) 0% 0%, var(--background) 0% 100%)`;
                self.loading = false;
            });
        },
        changeSrc(src) {
            document.querySelectorAll('img[data-photo-profile]').forEach(img => {
                img.src = src;
            });
        }
    };
}

function passwordChange() {
    return {
        form: {
            password: null,
            current_password: null,
            password_confirmation: null,
        },
        disabled: false,
        saved: false,
        errors: {},
        submit() {
            if (this.disabled) return;
            if (this.validation() === false) return;
            this.disabled = true;
            axios.request({
                ...userPassword.update(),
                data: this.form,
                withCredentials: true,
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
            }).then(response => {
                this.errors = {};
                this.form = {
                    password: null,
                    current_password: null,
                    password_confirmation: null,
                };
                this.saved = true;
            }).catch(error => {
                this.errors = error.response?.data?.errors || {};
                console.error('Error changing password:', this.errors);
            }).finally(() => {
                this.disabled = false;
                setTimeout(() => this.saved = false, 2000);
            });
        },

        validation() {
            this.errors = {};
            const strongPass = strongPassword(this.form.password);
            if (strongPass.valid === false) {
                this.errors.password = strongPass.messages;
            }
            if (confirmPassword(this.form.password, this.form.password_confirmation) === false) {
                this.errors.password_confirmation = ['كلمة المرور غير متطابقة.'];
            }
            return Object.keys(this.errors).length === 0;
        }
    };
}

function twoFactorAuth(enabled) {
    return {
        enabled: false,
        status: null,
        loading: false,
        qrCode: null,
        recoveryCodes: [],
        showingRecoveryCodes: false,
        regeneration: false,
        confirm: false,
        password: null,
        secretKey: null,
        passwordError: null,
        codeError: null,
        title: 'لم تقم بتفعيل المصادقة الثنائية.',
        copyed: false,
        init() {
            this.enabled = enabled;
            if (this.enabled) {
                this.title = 'لقد قمت بتفعيل المصادقة الثنائية.';
                this.status = "two-factor-authentication-enabled";
            }
            this.$refs.code.addEventListener('input', (e) => {
                e.currentTarget.value = e.currentTarget.value.replace(/[^\d]/g, '').replace(/(.{3})/, '$1-').slice(0, 7);
            });
        },
        async enable() {
            if (this.loading || !this.password) return;
            this.loading = true;
            try {
                await this.enable2FA();
                if (this.status === 'two-factor-authentication-confirm') {
                    this.enabled = true;
                    const [qrRes, secretRes] = await axios.all([
                        this.getQrCode(),
                        this.getSecretKey()
                    ]);
                    this.qrCode = qrRes.data.svg;
                    this.secretKey = secretRes.data.secretKey;
                    this.title = 'أنت في طور تفعيل المصادقة الثنائية.';
                    this.confirm = false;
                } else {
                    this.passwordError = 'كلمة المرور غير صحيحة.';
                }

            } catch (error) {
                if (error.response && error.response.status === 423) {
                    this.passwordError = error.response.data.message || 'كلمة المرور غير صحيحة.';
                } else {
                    this.passwordError = 'حدث خطأ ما. حاول مرة أخرى.';
                }
                console.error('Error enabling 2FA:', error);
            } finally {
                this.loading = false;
                this.password = null;
            }

        },
        confirm2FA() {
            if (this.loading) return;
            const code = this.$refs.code.value.replace(/-/g, '');
            if (code.length !== 6) {
                this.code = 'الرجاء إدخال رمز التحقق المكون من 6 أرقام.';
                return;
            }
            this.loading = true;
            axios.request({
                ...confirm(),
                data: { code: code },
                withCredentials: true,
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
            }).then(response => {
                this.status = 'two-factor-authentication-enabled';
                this.codeError = null;
                this.title = 'لقد قمت بتفعيل المصادقة الثنائية.';
            }).catch(error => {
                if (error.response && error.response.status === 422) {
                    this.codeError = error.response?.data?.message || 'رمز التحقق غير صحيح. حاول مرة أخرى.';
                } else {
                    this.codeError = 'حدث خطأ ما. حاول مرة أخرى.';
                }
                console.error('Error confirming 2FA:', error);
            }).finally(() => {
                this.loading = false;
                this.$refs.code.value = '';
            });
        },
        regenerateRecoveryCodes() {
            if (this.regeneration) return;
            this.regeneration = true;
            axios.request({
                ...regenerateRecoveryCodes(),
                withCredentials: true,
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
            }).then(response => {
                this.recoveryCodes = response.data || [];
                this.showingRecoveryCodes = true;
            }).catch(error => {
                console.error('Error regenerating recovery codes:', error);
            }).finally(() => {
                this.regeneration = false;
            });
        },
        disable() {
            if (this.loading) return;
            this.loading = true;
            axios.request({
                ...disable(),
                withCredentials: true,
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
            }).then(response => {
                this.enabled = false;
                this.status = null;
                this.qrCode = null;
                this.recoveryCodes = [];
                this.showingRecoveryCodes = false;
                this.confirm = false;
                this.password = null;
                this.secretKey = null;
                this.passwordError = null;
                this.codeError = null;
                this.title = 'لم تقم بتفعيل المصادقة الثنائية.';
            }).catch(error => {
                console.error('Error disabling 2FA:', error);
            }).finally(() => {
                this.loading = false;
            });
        },
        enable2FA() {
            return axios.request({
                ...enable(),
                data: { password: this.password },
                withCredentials: true,
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
            }).then(response => {
                this.status = 'two-factor-authentication-confirm';
                console.log(this.status);
            });
        },
        getQrCode() {
            return axios.request({
                ...qrCode(),
                withCredentials: true,
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
            });
        },
        getSecretKey() {
            return axios.request({
                ...secretKey(),
                withCredentials: true,
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
            });
        },
        getRecoveryCodes() {
            if (this.regeneration) return;
            this.regeneration = true;
            axios.request({
                ...recoveryCodes(),
                withCredentials: true,
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
            }).then(response => {
                this.recoveryCodes = response.data || [];
                this.showingRecoveryCodes = true;
            }).catch(error => {
                console.error('Error fetching recovery codes:', error);
            }).finally(() => {
                this.regeneration = false;
            });
        },
        copyToClipboard(text) {
            if (Array.isArray(text)) {
                text = text.join('\n');
            }
            if (!text || this.copyed) return;
            navigator.clipboard.writeText(text).then(() => {
                this.copyed = true;
                setTimeout(() => this.copyed = false, 2000);
            }).catch(err => {
                console.error('Could not copy text: ', err);
            });
        },
        downloadRecoveryCodes() {
            if (!this.recoveryCodes || this.recoveryCodes.length === 0) return;
            const element = document.createElement("a");
            const file = new Blob([this.recoveryCodes.join('\n')], { type: 'text/plain' });
            element.href = URL.createObjectURL(file);
            element.download = "recovery-codes.txt";
            document.body.appendChild(element);
            element.click();
            document.body.removeChild(element);
        }

    };
}



