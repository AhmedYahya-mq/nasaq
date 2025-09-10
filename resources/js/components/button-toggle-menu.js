
export default function buttonToggleMenu() {
    document.querySelector("input[data-button-toggle-menu]")?.addEventListener("change", e => {
        const svg = e.target.nextElementSibling;
        const topBottomLine = svg.querySelector(".stroke-primary");

        if (e.target.checked) {
            topBottomLine.style.strokeDasharray = "20 300";
            topBottomLine.style.strokeDashoffset = "-32.42";
            document.body.style.overflowY = "hidden";
        } else {
            topBottomLine.style.strokeDasharray = "12 63";
            topBottomLine.style.strokeDashoffset = "0";
            document.body.style.overflowY = "auto";
        }
        window.Alpine.store('menu').toggleMenu();
    });
}
