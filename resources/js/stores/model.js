
export function modelStore(Alpine) {
     Alpine.store('model', {
        on: false,
        init(on) {
            this.on = on;
        },
        toggle() {
            this.on = !this.on;
        },
        show() {
            this.on = true;
        },
        close() {
            this.on = false;
        }
    });
}
