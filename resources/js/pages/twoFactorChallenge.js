
document.addEventListener('alpine:init', () => {
    Alpine.data('twoFactorChallenge', twoFactorChallenge);
});

function twoFactorChallenge(hasRecoveryError = false) {
    return ({
        isCodeView: !hasRecoveryError,
        inputName: hasRecoveryError ? 'recovery_code' : 'code',
        inputValue: '',
        error: null,
        init() {
            this.$nextTick(() => {
                if (this.isCodeView) {
                    this.$refs.code.focus();
                } else {
                    this.$refs.recovery_code.focus();
                }
            });
            this.$watch('inputValue', value => {
                this.error = "";
                if (this.isCodeView) {
                    this.inputValue = value.replace(/[^\d]/g, '').replace(/(.{3})/, '$1-').slice(0, 7);
                    this.$refs.input.value = value.replace('-', '');
                } else {
                    value = value.replace(/[^a-zA-Z0-9]/g, '');
                    if (value.length > 10) {
                        value = value.slice(0, 10) + '-' + value.slice(10, 20);
                    }
                    this.inputValue = value.slice(0, 21);
                    this.$refs.input.value = value;
                }
            });
        },
        toogle() {
            this.isCodeView = !this.isCodeView;
            this.inputName = this.isCodeView ? 'code' : 'recovery_code';
            this.inputValue = '';
            this.$nextTick(() => {
                if (this.isCodeView) {
                    this.$refs.code.focus();
                } else {
                    this.$refs.recovery_code.focus();
                }
            });
        },
    });
};
