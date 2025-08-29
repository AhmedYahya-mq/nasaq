export default function hover() {
    return {
        isHovered: false,
        hideTimeout: null,

        onHoverStart(callback) {
            this.$el.addEventListener('mouseover', () => {
                if (this.hideTimeout) {
                    clearTimeout(this.hideTimeout);
                    this.hideTimeout = null;
                }
                this.isHovered = true;
                callback?.();
            });
        },
        onHoverEnd(callback) {
            this.$el.addEventListener('mouseout', (e) => {
                if (!this.$el.contains(e.relatedTarget)) {
                    this.hideTimeout = setTimeout(() => {
                        this.isHovered = false;
                        callback?.();
                    }, 100);
                }
            });
        },
        init() {
            this.onHoverEnd(() => { });
            this.onHoverStart(() => { });
        }
    }
}
