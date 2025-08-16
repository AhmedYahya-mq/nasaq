export default function registerMenuStore(Alpine) {
    Alpine.store('menu', {
        isOpen: false,
        toggleMenu() {
            this.isOpen = !this.isOpen;
        },
        closeMenu() {
            this.isOpen = false;
        }
        
    });

    // Initialize the menu store
    Alpine.store('menu').closeMenu();

}
