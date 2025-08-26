export default function hover() {
    return {
        isHovered: false,
        hideTimeout: null,

        onHoverStart(callback) {

            this.$el.addEventListener('mouseenter', () => {
                if (this.hideTimeout) {
                    clearTimeout(this.hideTimeout);
                    this.hideTimeout = null;
                }
                this.isHovered = true;
                callback?.();
            });
        },

        onHoverEnd(callback) {
            this.$el.addEventListener('mouseleave', () => {
                this.hideTimeout = setTimeout(() => {
                    this.isHovered = false;
                    console.log("Hover ended");
                    callback?.();
                }, 100);
            });
        },
        init() {
            this.onHoverEnd(() => {});
            this.onHoverStart(() => {});
        }
    }
}
