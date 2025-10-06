import html2canvas from 'html2canvas';
import { jsPDF } from 'jspdf'; 

document.addEventListener('alpine:init', function () {
    Alpine.data('printInit', printInit);
});

function printInit() {
    return {
        isLoadingPng: false,
        isLoadingPdf: false,

        async downloadTransparent() {
            const card = this.$refs.card;
            if (!card) return;
            this.isLoadingPng = true;
            setTimeout(async () => {
                try {
                    const canvas = await html2canvas(card, {
                        backgroundColor: null,
                        scale: 2,
                        useCORS: true
                    });

                    const link = document.createElement('a');
                    link.download = 'membership-card.png';
                    link.href = canvas.toDataURL('image/png');
                    link.click();
                } catch (error) {
                    console.error('html2canvas failed:', error);
                } finally {
                    this.isLoadingPng = false;
                }
            }, 100);
        },

        // ---------------------------
        // دالة جديدة لتوليد PDF
        async downloadPDF() {
            const card = this.$refs.card;
            if (!card) return;
            this.isLoadingPdf = true;

            setTimeout(async () => {
                try {
                    const canvas = await html2canvas(card, {
                        backgroundColor: null,
                        scale: 2,
                        useCORS: true
                    });

                    const imgData = canvas.toDataURL('image/png');

                    // أبعاد البطاقة
                    const pdf = new jsPDF({
                        orientation: 'landscape',
                        unit: 'px',
                        format: [canvas.width, canvas.height]
                    });

                    pdf.addImage(imgData, 'PNG', 0, 0, canvas.width, canvas.height);
                    pdf.save('membership-card.pdf');

                } catch (error) {
                    console.error('PDF generation failed:', error);
                } finally {
                    this.isLoadingPdf = false;
                }
            }, 100);
        }
    };
}
