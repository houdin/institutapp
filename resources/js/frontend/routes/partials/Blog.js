// Route::get('category/{category}/blogs', [BlogController::class, 'getByCategory'])->name('blogs.category');
// Route::get('tag/{tag}/blogs', [BlogController::class, 'getByTag'])->name('blogs.tag');
// Route::get('blog/{slug?}', [BlogController::class, 'getIndex'])->name('blogs.index');
// Route::post('blog/{id}/comment', [BlogController::class, 'storeComment'])->name('blogs.comment');
// Route::get('blog/comment/delete/{id}', [BlogController::class, 'deleteComment'])->name('blogs.comment.delete');

export default [
    {
        path: "/blog",
        component: require("../../../components/blogs/Blog").default,

        children: [
            {
                name: "blogs.index",
                path: "",
                component: require("../../../components/blogs/BlogIndex")
                    .default,
                meta: {
                    enterClass: "animate__animated animate__fadeInLeft",
                    leaveClass: "animate__animated animate__fadeOutRight",

                    pageTitle: {
                        title: "Notre |Blog",
                        content: "C'est notre blog les gars!! :)",
                        inverse_color: true,
                    },
                },
            },
            {
                name: "blogs.show",
                path: ":slug",
                component: require("../../../components/blogs/BlogShow")
                    .default,
                meta: {
                    enterClass: "animate__animated animate__fadeInRight",
                    leaveClass: "animate__animated animate__fadeOutLeft",
                    breadCrumb(route) {
                        const slug = route.params.slug;
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
                name: "blogs.comment",
                path: ":id/comment",
                component: require("../../../components/blogs/BlogShow")
                    .default,
            },
            {
                name: "blogs.comment.delete",
                path: "comment/delete/:id",
                component: require("../../../components/blogs/BlogShow")
                    .default,
            },
        ],
    },
];
