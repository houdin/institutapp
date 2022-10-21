export default [
    {
        path: "/tag",
        component: require("../../../components/category/Tag").default,

        children: [
            {
                name: "blogs.tag",
                path: ":tag/blogs",
                component: require("../../../components/blogs/BlogIndex")
                    .default,
                meta: {
                    enterClass: "animate__animated animate__fadeInLeft",
                    leaveClass: "animate__animated animate__fadeOutRight",
                },
            },
        ],
    },
];
