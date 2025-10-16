window.downloadCard = async function(element, fill_name = 'card.png') {
    if (!element) return;

    const canvas = await html2canvas(element, {
        backgroundColor: null, // خلفية شفافة
        scale: 2,
        useCORS: true
    });

    const link = document.createElement('a');
    link.download = fill_name;
    link.href = canvas.toDataURL('image/png');
    link.click();
}
