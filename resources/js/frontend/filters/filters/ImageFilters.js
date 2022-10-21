import format from "date-fns/format";
function get_image_size(num_size = null) {
    var size = "";

    switch (num_size) {
        case 1:
            size = "400";
            break;
        case 2:
            size = "540";
            break;
        case 3:
            size = "750";
            break;
        case 4:
            size = "1350";
            break;
        case 5:
            size = "1850";
    }

    return size;
}

export default {
    featuredImage: (value, num_size) => {
        // var date = value.created_at.split("-", 2);
        const date = format(new Date(value.created_at), "Y/m/");
        // date = date[0] + "/" + date[1] + "/";

        var size = num_size ? "-" + get_image_size(num_size) : "";

        return date + value.file_name + size + "w." + value.extension;
    },

    featuredImageUrl: (value, num_size) => {
        const size = num_size ? get_image_size(num_size) : "";

        let url = value.url.replace("origin", "resizing/" + size);

        url = url.replace(value.file_name, value.file_name + "-" + size + "w");

        return url;
    },
};
