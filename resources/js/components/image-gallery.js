export default function imageGallery(images, imagesPerPage = 20) {
    return {
        images: images,
        page: 0,
        imagesPerPage: imagesPerPage,
        isTouch: ('ontouchstart' in window || navigator.maxTouchPoints > 0),
        isOpen: false,
        activeIndex: 0,
        showHint: localStorage.getItem('galleryHintDismissed') !== '1',

        get pagedImages() {
            return this.images.slice(this.page * this.imagesPerPage, (this.page + 1) * this.imagesPerPage);
        },
        pageCount() {
            return Math.ceil(this.images.length / this.imagesPerPage);
        },
        openLightbox(index) {
            this.activeIndex = index + this.page * this.imagesPerPage;
            this.isOpen = true;
        },
        next() {
            if (this.page < this.pageCount() - 1) this.goToPage(this.page + 1);
        },
        prev() {
            if (this.page > 0) this.goToPage(this.page - 1);
        },
        goToPage(p) {
            this.page = p;
        },
        goToImage(i) {
            this.activeIndex = i;
        },
        lightboxNext() {
            this.activeIndex = (this.activeIndex + 1) % this.images.length;
        },
        lightboxPrev() {
            this.activeIndex = (this.activeIndex - 1 + this.images.length) % this.images.length;
        },
        dismissHint() {
            this.showHint = false;
            localStorage.setItem('galleryHintDismissed', '1');
        },
        handleTouch($refs) {
            let startX = null;
            let threshold = 50;
            $refs.lightbox.addEventListener('touchstart', e => {
                if (e.touches.length === 1) startX = e.touches[0].clientX;
            });
            $refs.lightbox.addEventListener('touchend', e => {
                if (startX === null) return;
                let endX = e.changedTouches[0].clientX;
                let diff = endX - startX;
                if (Math.abs(diff) > threshold) {
                    if (diff < 0) { this.lightboxNext(); }
                    else { this.lightboxPrev(); }
                    this.dismissHint();
                }
                startX = null;
            });
        }
    }
}
