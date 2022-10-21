export default {
    cartSession: async (value, type = "formation") => {
        let path = {
            formation: "/formation/formation-cart-elem",
            tutorial: "/tutorial/tutorial-cart-elem",
            bundle: "/bundle/bundle-cart-elem",
            product: "/product/product-cart-elem",
            premium: "/premium/premium-cart-elem",
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
        return false;
    },

    cart_session_elem: async (value) => {
        try {
            let res = await axios.get("/formation/formation-cart-elem", {
                formation_id: value,
            });
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

        return false;
    },
};
