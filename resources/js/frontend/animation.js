const removeAnimateClass = (el) => {
    const matches = [];
    el.classList.forEach((value) => {
        //remove page-parent
        if (/^animate__.+/.test(value)) {
            matches.push(value);
        }
    });
    matches.forEach((value) => {
        el.classList.remove(value);
    });
};

export const animateCSS = (element, animation, duration = 2) => {
    const prefix = "animate__";
    // We create a Promise and return it
    new Promise((resolve, reject) => {
        const node = document.querySelector(element);
        removeAnimateClass(node);

        const animationName = `${prefix}${animation}`;

        if (node) {
            node.classList.add(`${prefix}animated`, animationName);

            // When the animation ends, we clean the classes and resolve the Promise
            function handleAnimationEnd(event) {
                event.stopPropagation();
                node.classList.remove(`${prefix}animated`, animationName);
                resolve("Animation ended");
            }

            node.addEventListener("animationend", handleAnimationEnd, {
                once: true,
            });
        }
    });
};
