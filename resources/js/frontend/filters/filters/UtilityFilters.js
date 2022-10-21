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
    inarray: function inarray(value, array) {
        // var node = document.createElement("div");
        // node.innerHTML = value;
        // var content = node.textContent;
        return $.inArray(value, array);
    },

    occurrence_count: function occurrence_count(value, arr, target) {
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

    segments: function segments(url = null) {
        // const path = (window.location.pathname[0] = "");

        const pathArray =
            url !== null ? url.split("/") : window.location.pathname.split("/");

        pathArray.shift();

        return pathArray;
    },

    segment: function segment(num, url = null) {
        const all_segments = this.segments(url);
        return all_segments[num - 1];
    },

    promiseTimeOut: async (sec = 1000) => {
        await new Promise((resolve) => {
            setTimeout(resolve, sec);
        });
    },
    number_format: function number_format(num, sep = " ") {
        num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, sep);
    },
    proxy: function proxy(target) {
        const handler = {
            get(target, property) {
                // console.log('intercepted!')
                return target[property];
            },
        };
        return new Proxy(target, handler);
    },
};

export default Utility;
