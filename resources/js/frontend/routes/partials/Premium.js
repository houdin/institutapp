export default [
    {
        path: "/premium",
        component: require("../../../components/premium/Premium").default,
        meta: {
            breadcrumb: "Premium",
        },
        children: [
            {
                name: "premium.index",
                path: "",
                component: require("../../../components/premium/PremiumIndex")
                    .default,
                meta: {
                    breadcrumb: "Premium",
                },
            },
            {
                name: "premium.show",
                path: ":level",

                components: {
                    premium: require("../../../components/premium/PremiumShow")
                        .default,
                },
            },
        ],
    },
];
