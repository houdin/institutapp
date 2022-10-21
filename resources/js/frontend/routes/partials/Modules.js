export default [
    {
        path: "/module",
        component: require("../../../components/formations/Modules").default,
        children: [
            {
                name: "modules.show",
                path: ":formation_id/:slug/",
                component: require("../../../components/formations/Modules")
                    .default,
            },
            {
                name: "modules.test",
                path: ":slug/test",
                component: require("../../../components/formations/Modules")
                    .default,
                meta: {
                    breadcrumb: "Modules",
                },
            },
            {
                name: "modules.retest",
                path: ":slug/retest",
                component: require("../../../components/formations/Modules")
                    .default,
                meta: {
                    breadcrumb: "Formation",
                },
            },

            {
                name: "update.formation.progress",
                path: "progress",
                component: require("../../../components/formations/Modules")
                    .default,
                meta: {
                    breadcrumb: "Formation",
                },
            },
        ],
    },

    {
        name: "update.videos.progress",
        path: "/video/progress",
        component: require("../../../components/formations/Modules").default,
        meta: {
            breadcrumb: "Formation",
        },
    },
];
