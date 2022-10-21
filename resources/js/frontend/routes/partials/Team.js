// Route::get('category/{category}/blogs', [BlogController::class, 'getByCategory'])->name('blogs.category');
// Route::get('tag/{tag}/blogs', [BlogController::class, 'getByTag'])->name('blogs.tag');
// Route::get('blog/{slug?}', [BlogController::class, 'getIndex'])->name('blogs.index');
// Route::post('blog/{id}/comment', [BlogController::class, 'storeComment'])->name('blogs.comment');
// Route::get('blog/comment/delete/{id}', [BlogController::class, 'deleteComment'])->name('blogs.comment.delete');

export default [
    {
        name: "team_index",
        path: "/team",
        component: require("../../../components/blogs/BlogIndex").default,
    },
];
