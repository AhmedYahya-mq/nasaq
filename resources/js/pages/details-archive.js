import imageGallery from "@client/components/image-gallery";

document.addEventListener('alpine:init', () => {
    Alpine.data('imageGallery', imageGallery);
});
