import { ref, watch } from "vue";
// import nearestColor from "nearest-color";

// import colorNameList from "color-name-list";
// const getColorName = new GetColorName();
// function GetColorName() {
//   const colors = colorNameList.reduce(
//     (o, { name, hex }) => Object.assign(o, { [name]: hex }),
//     {}
//   );
//   const nearest = nearestColor.from(colors);
//   return (hexColor) => nearest(hexColor).name;
// }
const Utility = {
    inarray: function (value, array) {
        // var node = document.createElement("div");
        // node.innerHTML = value;
        // var content = node.textContent;
        return $.inArray(value, array);
    },

    occurrence_count: function (value, arr, target) {
        var numOccurences = $.grep(arr, function (elem) {
            return elem === target;
        }).length;
        return numOccurences;
    },

    toarray: function toarray(value, arr, target) {
        var numOccurences = $.grep(arr, function (elem) {
            return elem === target;
        }).length;
        return numOccurences;
    },

    segments: function (url = null) {
        // const path = (window.location.pathname[0] = "");

        const pathArray =
            url !== null ? url.split("/") : window.location.pathname.split("/");

        pathArray.shift();

        return pathArray;
    },

    segment: function (num, url = null) {
        const all_segments = this.segments(url);
        return all_segments[num - 1];
    },

    timeOut: async (sec = 1000) => {
        await new Promise((resolve) => {
            setTimeout(resolve, sec);
        });
    },
    number_format: function number_format(num, sep = " ") {
        num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, sep);
    },
    proxy: function (target) {
        const handler = {
            get(target, property) {
                // console.log('intercepted!')
                return target[property];
            },
        };
        return new Proxy(target, handler);
    },

    rewriter: function (text) {
        let val = text;
        switch (text) {
            case "blog":
                val = "article";
                break;
            case "article":
                val = "blog";
                break;

            default:
                break;
        }
        return val;
    },

    // speed: function(){
    //     const prevEvent = ref<MouseEvent>();
    //     const currentEvent = ref<MouseEvent>();
    //     const mouseMouvementX = ref(0);
    //     const mouseMouvementY = ref(0);
    //     const mouvement = ref(0);
    //     const speed = ref(0);
    //     document.documentElement.onmousemove = (event) => {
    //         currentEvent.value = event
    //     }

    //     watch(currentEvent, async (val, prev) => {
    //         await Helpers.Utility.timeOut(90)
    //         if (currentEvent.value && prevEvent.value) {
    //             mouseMouvementX.value = Math.abs(currentEvent.value.screenX - prevEvent.value.screenX)
    //             mouseMouvementY.value = Math.abs(currentEvent.value.screenY - prevEvent.value.screenY)
    //             mouvement.value = Math.round(Math.sqrt(mouseMouvementX.value * mouseMouvementX.value + mouseMouvementY.value * mouseMouvementY.value))
    //             speed.value = 10 * mouvement.value;
    //             // console.log(speed.value, prevEvent.value.screenX)
    //         }
    //         prevEvent.value = currentEvent.value;
    //     })

    //     return {current: currentEvent.value, previous: prevEvent.value}
    // }
};

export default Utility;
