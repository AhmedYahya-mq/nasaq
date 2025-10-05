import payForm from "@client/components/payForm";


document.addEventListener('alpine:init', () => {
    Alpine.data('payForm', payForm);
});
