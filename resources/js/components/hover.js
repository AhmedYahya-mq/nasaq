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
                console.log("Hover started");

                callback?.();
            });
        },

        onHoverEnd(callback) {
            this.$el.addEventListener('mouseleave', () => {
                this.hideTimeout = setTimeout(() => {
                    this.isHovered = false;
                    console.log("Hover ended");
                    callback?.();
                }, 50);
            });
        },
        init() {
            this.onHoverEnd(() => {});
            this.onHoverStart(() => {});
        }
    }
}
