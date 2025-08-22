import { animate, stagger, svg } from "animejs";
import runAnimetion, { animateCardsOnScroll, counterAnimation, drawSvgLines } from "./animations/scrollAnimetion"
import runAnimetionWaapi from "./animations/scrollAnimetionWaapi";

export default () => {
    counterAnimation();
    drawSvgLines('.line');
    //if waapi is not supported, use the original scrollAnimationText

    if (!'animate' in Element.prototype) {
        runAnimetion();
    } else {
        runAnimetionWaapi();
    }
}
