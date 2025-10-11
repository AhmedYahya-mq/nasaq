import { animate } from 'animejs';

document.addEventListener("alpine:init", () => {
    Alpine.data("flyAnimation", flyAnimation);
});

function flyAnimation() {
    return {
        /**
         * الدالة الرئيسية
         * @param {HTMLElement} fromEl - العنصر اللي ضغط عليه المستخدم
         * @param {string} selector - اختياري، محدد الهدف، الافتراضي [data-fly-target]
         */
        async flyTo(selector = ".point") {
            const target = document.querySelector(selector);
            //  fromEl هو ref flyCard في هذا السياق
            const fromEl = this.$refs.flyCard;
            if (!fromEl || !target) return;

            const fromRect = fromEl.getBoundingClientRect();
            const targetRect = target.getBoundingClientRect();

            // احسب scroll offset للصفحة
            const scrollX = window.scrollX || window.pageXOffset;
            const scrollY = window.scrollY || window.pageYOffset;

            const fromX = fromRect.left + scrollX;
            const fromY = fromRect.top + scrollY;

            const targetX = targetRect.left + scrollX;
            const targetY = targetRect.top + scrollY;

            const deltaX = targetX - fromX;
            const deltaY = targetY - fromY;

            console.log(deltaX, deltaY);


            // إنشاء نسخة clone شفافة
            const clone = fromEl.cloneNode(true);
            clone.style.position = "fixed";
            clone.style.left = `${fromX}px`;
            clone.style.top = `${fromY}px`;
            clone.style.width = `${fromRect.width}px`;
            clone.style.height = `${fromRect.height}px`;
            clone.style.zIndex = "9999";
            clone.style.pointerEvents = "none";
            clone.style.opacity = "0.7";
            clone.style.transformOrigin = "center center";
            document.body.appendChild(clone);
            // حركة النسخة
            animate(clone, {
                translateX: deltaX,
                translateY: deltaY,
                scale: 0.1,
                opacity: [0.7, 0],
                duration: 900,
                easing: "easeInOutCubic",
            }).then(() => {
                clone.remove();
                animate(target, {
                    scale: [1, 1.2, 1],
                    boxShadow: [
                        "0 0 0 rgba(0,0,0,0)",
                        "0 0 20px rgba(59,130,246,0.6)",
                        "0 0 0 rgba(0,0,0,0)"
                    ],
                    duration: 400,
                    easing: "easeInOutQuad",
                });
            });
        },
    };
}
