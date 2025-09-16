
export function modelStore(Alpine) {
     Alpine.store('model', {
        on: false,
        init(on) {
            this.on = on;
            console.log("model init = "+this.on);
        },
        toggle() {
            this.on = !this.on;
        },
        show() {
            this.on = true;
            console.log("show = "+this.on);

        },
        close() {
            this.on = false;
            console.log("close = "+this.on);
        }
    });
}
