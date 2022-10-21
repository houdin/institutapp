export default [
    {
        name: "home",
        path: "/",
        component: require("../../../components/home/HomePage").default,
        meta: {
            breadcrumb: false,
        },
    },
    {
        name: "test_modal",
        path: "/test-modal",
        component: require("../../../components/functionality/modal/TestModal")
            .default,
        meta: {
            breadcrumb: false,
        },
    },
];
