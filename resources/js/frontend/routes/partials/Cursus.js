export default [
    {
        path: "/cursus",
        component: require("../../../components/cursus/Cursus").default,
        meta: {
            breadcrumb: "Cursus",
        },
        children: [
            {
                name: "cursus.index",
                path: "",
                component: require("../../../components/cursus/CursusIndex")
                    .default,
                meta: {
                    enterClass: "animate__animated animate__fadeInLeft",
                    leaveClass: "animate__animated animate__fadeOutRight",
                    pageTitle: {
                        title: "Toutes Nos |Formations",
                        content: "Nous sommes là pour vous !",
                    },
                },
            },
            {
                name: "cursus.show",
                path: ":slug",
                component: require("../../../components/cursus/CursusShow")
                    .default,

                meta: {
                    enterClass: "animate__animated animate__fadeInRight",
                    leaveClass: "animate__animated animate__fadeOutLeft",
                    breadCrumb(route) {
                        const slug = route.params.slug;
                        return [
                            {
                                text: "Cursus",
                                to: { name: "cursus.index" },
                            },
                            {
                                text: slug,
                            },
                        ];
                    },
                },
                // props: true,
                // beforeEnter: (to, from, next) => {
                //     if (!userById($route.params.id)) {
                //         next("/404");
                //     } else {
                //         next();
                //     }
                // },
            },
        ],
    },
];
