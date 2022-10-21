// Route::get('category/{category}/blogs', [BlogController::class, 'getByCategory'])->name('blogs.category');
// Route::get('tag/{tag}/blogs', [BlogController::class, 'getByTag'])->name('blogs.tag');
// Route::get('blog/{slug?}', [BlogController::class, 'getIndex'])->name('blogs.index');
// Route::post('blog/{id}/comment', [BlogController::class, 'storeComment'])->name('blogs.comment');
// Route::get('blog/comment/delete/{id}', [BlogController::class, 'deleteComment'])->name('blogs.comment.delete');

export default [
    {
        name: "specials_effects_index",
        path: "/effets-speciaux",
        component: require("../../../components/blogs/BlogIndex").default,
    },
    {
        name: "3d_after_effects",
        path: "/3d-&-after-effects",
        component: require("../../../components/blogs/BlogIndex").default,
    },
    {
        name: "design_graphics",
        path: "/design-graphics",
        component: require("../../../components/blogs/BlogIndex").default,
    },
    {
        name: "storyboard",
        path: "/storyboard",
        component: require("../../../components/blogs/BlogIndex").default,
    },
    {
        name: "web_applications",
        path: "/web-&-applications",
        component: require("../../../components/blogs/BlogIndex").default,
    },
    {
        name: "location",
        path: "/location",
        component: require("../../../components/blogs/BlogIndex").default,
    },
    {
        name: "plugins",
        path: "/plugins",
        component: require("../../../components/blogs/BlogIndex").default,
    },
    {
        name: "modeles_3d",
        path: "/modeles-3d",
        component: require("../../../components/blogs/BlogIndex").default,
    },
    {
        name: "applications",
        path: "/applications",
        component: require("../../../components/blogs/BlogIndex").default,
    },
];
