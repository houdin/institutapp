export default [
    {
        path: "/formations",
        component: require("../../../components/formations/Formations").default,
        meta: {
            breadcrumb: "Formations",
        },
        children: [
            {
                name: "formations.index",
                path: "",
                component:
                    require("../../../components/formations/FormationsIndex")
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
                name: "formations.show",
                path: ":slug",
                component:
                    require("../../../components/formations/FormationShow")
                        .default,

                meta: {
                    enterClass: "animate__animated animate__fadeInRight",
                    leaveClass: "animate__animated animate__fadeOutLeft",
                    breadCrumb(route) {
                        const slug = route.params.slug;
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
                // props: true,
                // beforeEnter: (to, from, next) => {
                //     if (!userById($route.params.id)) {
                //         next("/404");
                //     } else {
                //         next();
                //     }
                // },
            },
            {
                name: "formations.rating",
                path: ":formation_id/rating",
                component:
                    require("../../../components/formations/FormationShow")
                        .default,
                meta: {
                    breadcrumb: "Formation",
                },
            },
            {
                name: "formations.review",
                path: ":id/review",
                component:
                    require("../../../components/formations/FormationShow")
                        .default,
                meta: {
                    breadcrumb: "Formation",
                },
            },
            {
                name: "formations.review.edit",
                path: "review/:id/edit",
                component:
                    require("../../../components/formations/FormationShow")
                        .default,
                meta: {
                    breadcrumb: "Formation",
                },
            },
            {
                name: "formations.review.update",
                path: "review/:id/edit",
                component:
                    require("../../../components/formations/FormationShow")
                        .default,
                meta: {
                    breadcrumb: "Formation",
                },
            },
            {
                name: "formations.review.delete",
                path: "review/:id/delete",
                component:
                    require("../../../components/formations/FormationShow")
                        .default,
                meta: {
                    breadcrumb: "Formation",
                },
            },
        ],
    },

    {
        path: "/devis/personal-information",
        component:
            require("../../../components/quotation/QuotationPersonalInformation")
                .default,
    },
];
