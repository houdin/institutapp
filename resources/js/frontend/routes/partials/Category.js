export default [
    {
        path: "/category",
        component: require("../../../components/category/Category").default,

        children: [
            {
                name: "blogs.category",
                path: ":category/blogs",
                component: require("../../../components/blogs/BlogIndex")
                    .default,
                meta: {
                    enterClass: "animate__animated animate__fadeInLeft",
                    leaveClass: "animate__animated animate__fadeOutRight",
                    breadCrumb(route) {
                        const slug = route.params.category;
                        return [
                            {
                                text: "Blog",
                                to: { name: "blogs.index" },
                            },
                            {
                                text: slug,
                            },
                        ];
                    },
                },
            },
            {
                name: "formations.category",
                path: ":category/formations",
                component:
                    require("../../../components/formations/FormationsIndex")
                        .default,
                meta: {
                    enterClass: "animate__animated animate__fadeInLeft",
                    leaveClass: "animate__animated animate__fadeOutRight",
                    breadCrumb(route) {
                        const slug = route.params.category;
                        return [
                            {
                                text: "Formations",
                                to: { name: "formations.index" },
                            },
                            {
                                text: slug,
                            },
                        ];
                    },
                },
            },
            {
                name: "tutorials.category",
                path: ":category/tutoriels",
                component:
                    require("../../../components/tutorials/TutorialsIndex")
                        .default,
                meta: {
                    enterClass: "animate__animated animate__fadeInLeft",
                    leaveClass: "animate__animated animate__fadeOutRight",
                    breadCrumb(route) {
                        const slug = route.params.category;
                        return [
                            {
                                text: "Tutoriels",
                                to: { name: "tutorials.index" },
                            },
                            {
                                text: slug,
                            },
                        ];
                    },
                },
            },
            {
                name: "bundles.category",
                path: ":category/bundles",
                component: require("../../../components/bundles/BundlesIndex")
                    .default,
                meta: {
                    enterClass: "animate__animated animate__fadeInLeft",
                    leaveClass: "animate__animated animate__fadeOutRight",
                    breadCrumb(route) {
                        const slug = route.params.category;
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
        ],
    },
];
