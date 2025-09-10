export default function photoProfile(Alpine) {
    Alpine.store('photoProfile', {
        src: '',
        fileInput: null,
        openFileDialog() {
            if (this.fileInput) {
                this.fileInput.click();
            }
        },
        updateFile(event) {
            const file = event.target.files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.onload = (e) => {
                this.changeSrc(e.target.result);
            };
            reader.readAsDataURL(file);
        },

        changeSrc(src) {
            this.src = src;
            document.querySelectorAll('img[data-photo-profile]').forEach(img => {
                img.src = src;
            });
        }
    });
    Alpine.store('photoProfile');
}
