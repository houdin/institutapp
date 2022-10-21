import { marked } from "marked";

export default {
    md: (msg) => {
        return marked.parse(msg);
    },
    truncate: function truncate(value, length = 100, clamp = "...") {
        // var node = document.createElement("div");
        // node.innerHTML = value;
        // var content = node.textContent;
        return value.length > length ? value.slice(0, length) + clamp : value;
    },
};
