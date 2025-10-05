
export default function buttonToggleMenu() {
    document.querySelector("input[data-button-toggle-menu]")?.addEventListener("change", e => {
        const svg = e.target.nextElementSibling;
        const topBottomLine = svg.querySelector(".stroke-primary");
        const container = document.body.querySelector("div");

        if (e.target.checked) {
            topBottomLine.style.strokeDasharray = "20 300";
            topBottomLine.style.strokeDashoffset = "-32.42";
            container.style.overflowY = "hidden";
        } else {
            topBottomLine.style.strokeDasharray = "12 63";
            topBottomLine.style.strokeDashoffset = "0";
            container.style.overflowY = "auto";
        }
        window.Alpine.store('menu').toggleMenu();
    });
}
