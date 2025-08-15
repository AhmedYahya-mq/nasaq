import { createPopper } from '@popperjs/core';
window.createPopper = createPopper;

export default function dropdown() {
    return {
        open: false,
        popperInstance: null,
        init() {
            this.$nextTick(() => {
                if (this.$refs.menu) {
                    this.popperInstance = createPopper(this.$refs.button, this.$refs.menu, {
                        placement: 'bottom-start',
                        modifiers: [
                            { name: 'flip', options: { fallbackPlacements: ['bottom-end', 'top-start', 'top-end'] } },
                            { name: 'preventOverflow', options: { padding: 8 } },
                            { name: 'offset', options: { offset: [0, 2] } }
                        ],
                    });
                    this.popperInstance.update();
                }
            });
        },
        async toggle() {
            this.open = !this.open;
            await this.$nextTick();
            if (this.open) this.popperInstance.update();
        },
        close() {
            this.open = false;
        }
    }
}
