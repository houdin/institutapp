export default [
    {
        name: "pageNotFound",
        path: "/:pathMatch(.*)*",
        component: require("../../../components/errors/Error404").default,
        meta: {
            pageTitle: {
                title: "Page |Introuvable",
                content: "Erreur 404",
            },
        },
    },
    {
        name: "pageNotFounds",
        path: "/user-:afterUser(.*)",
        component: require("../../../components/errors/Error404").default,
    },
];
