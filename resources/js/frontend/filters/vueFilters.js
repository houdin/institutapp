const asset = (value) => {
    // var node = document.createElement("div");
    // node.innerHTML = value;
    // var content = node.textContent;
    return window.Laravel.urls.index + "/" + value;
};

const config = async (value) => {
    let res;
    try {
        res = await axios.post(Laravel.urls.appconfig, { conf: value });
        if (res.status == 200) {
            // test for status you want, etc
            //console.log(res.status);
            return res.data.conf;
        }

        // Don't forget to return something
        //return res.data;
    } catch (err) {
        console.error(err);
    }

    return false;
};
const asyncr = async (val) => {
    return await val;
};

import Auth from "./filters/AuthFilters";
import Session from "./filters/SessionFilters";
import Image from "./filters/ImageFilters";
import Utility from "./filters/UtilityFilters";
import Text from "./filters/TextFilters";

export default {
    Auth,
    Session,
    Image,
    Utility,
    Text,
    asset,
    config,
    asyncr,
};
