
export default function loading() {
    // Initialize loading state
    document.addEventListener('DOMContentLoaded', () => {
        document.body.style.overflow = 'hidden';
        setTimeout(() => {
            document.getElementById('loading').remove();
            document.body.style.overflowY = 'auto';
        }, 1000);
    });
}
