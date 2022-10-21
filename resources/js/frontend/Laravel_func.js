function get_image_size(num_size = null, switcher = false) {
    var size = "";

    switch (num_size) {
        case 1:
            size = "50x50";
            break;
        case 2:
            size = "120x90";
            break;
        case 3:
            size = "293x260";
            break;
        case 4:
            size = "395x200";
            break;
        case 5:
            size = "688x260";
            break;
        case null:
            size = "";
            break;
    }

    if (switcher == true) {
        return size.split("x");
    }

    return size;
}

const featuredImage = (value, num_size) => {
    var date = value.image.created_at.split("-", 2);
    date = date[0] + "/" + date[1] + "/";

    var extension = value.image.name.split(".");
    extension = extension[extension.length - 1];

    var fileName = "";
    if (value.image.file_name.indexOf(".") !== -1) {
        var name = value.image.file_name.split(".");
        if (name[name.length - 1].length === 3) {
            fileName = value.image.name.replace(
                "." + name[name.length - 1],
                ""
            );
        }
    } else {
        fileName = value.image.file_name;
    }

    var size = num_size ? "-" + get_image_size(num_size) : "";

    return date + fileName + size + "." + extension;
};

const featuredImageUrl = (value, num_size) => {
    var date = value.image.created_at.split("-", 2);
    date = date[0] + "/" + date[1] + "/";

    var extension = value.image.name.split(".");
    extension = extension[extension.length - 1];

    var size = num_size ? "-" + get_image_size(num_size) : "";

    var fileName = "";
    if (value.image.file_name.indexOf(".") !== -1) {
        var name = value.image.file_name.split(".");
        if (name[name.length - 1].length === 3) {
            fileName = value.image.name.replace(
                "." + name[name.length - 1],
                ""
            );
        }
    } else {
        fileName = value.image.file_name;
    }

    var url = value.image.url.replace(
        value.image.file_name,
        fileName + size + "." + extension
    );

    return url;
};

const asset = value => {
    // var node = document.createElement("div");
    // node.innerHTML = value;
    // var content = node.textContent;
    return window.Laravel.urls.index + "/" + value;
};

const cartSession = async (value, type = "formation") => {
    let path = {
        formation: "/formation/formation-cart-elem",
        tutorial: "/tutorial/tutorial-cart-elem",
        bundle: "/bundle/bundle-cart-elem",
        product: "/product/product-cart-elem",
        premium: "/premium/premium-cart-elem"
    };

    try {
        let res = await axios.get(path[type] + "/" + value);
        if (res.status == 200) {
            // test for status you want, etc
            //console.log(res.status);
        }
        return res.data.cart_elem;
        // Don't forget to return something
        //return res.data;
    } catch (err) {
        console.error(err);
    }
};

const empty = value => {
    return Object.keys(value).length > 0;
};

export default { featuredImage, featuredImageUrl, asset, cartSession, empty };
