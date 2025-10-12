import downloadResource from "@client/components/downloadResource";


document.addEventListener('alpine:init', () => {
    Alpine.data('downloadResource', downloadResource);
});
