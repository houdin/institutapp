export default [
    {
        path: "/bundles",
        component: require("../../../components/bundles/Bundles").default,

        children: [
            {
                name: "bundles.index",
                path: "",
                component: require("../../../components/bundles/BundlesIndex")
                    .default,
                meta: {
                    enterClass: "animate__animated animate__fadeInLeft",
                    leaveClass: "animate__animated animate__fadeOutRight",
                },
            },
            {
                name: "bundles.show",
                path: ":slug",
                component: require("../../../components/bundles/BundleShow")
                    .default,
                meta: {
                    enterClass: "animate__animated animate__fadeInRight",
                    leaveClass: "animate__animated animate__fadeOutLeft",
                    breadCrumb(route) {
                        const slug = route.params.slug;
                        return [
                            {
                                text: "Bundles",
                                to: { name: "bundles.index" },
                            },
                            {
                                text: slug,
                            },
                        ];
                    },
                },
            },
            {
                name: "bundles.rating",
                path: ":bundle_id/rating",
                component: require("../../../components/bundles/BundleShow")
                    .default,
                meta: {
                    breadcrumb: "Bundle",
                },
            },

            {
                name: "bundles.review",
                path: ":id/review",
                component: require("../../../components/bundles/BundleShow")
                    .default,
                meta: {
                    breadcrumb: "Bundle",
                },
            },
            {
                name: "bundles.review.edit",
                path: "review/:id/edit",
                component: require("../../../components/bundles/BundleShow")
                    .default,
                meta: {
                    breadcrumb: "Bundle",
                },
            },
            {
                name: "bundles.review.update",
                path: "review/:id/update",
                component: require("../../../components/bundles/BundleShow")
                    .default,
                meta: {
                    breadcrumb: "Bundle",
                },
            },
            {
                name: "bundles.review.delete",
                path: "review/:id/delete",
                component: require("../../../components/bundles/BundleShow")
                    .default,
                meta: {
                    breadcrumb: "Bundle",
                },
            },
        ],
    },
];
