//============Tutorial Routes=================//
// Route::get('tutoriels', [TutorialsController::class, 'all'])->name('tutorials.all');
// Route::get('tutoriel/{slug}', [TutorialsController::class, 'show'])->name('tutorials.show');
// //Route::post('tutorial/payment', [TutorialsController::class, 'payment'])->name('tutorials.payment');
// Route::post('tutoriel/{tutorial_id}/rating', [TutorialsController::class, 'rating'])->name('tutorials.rating');
// Route::get('category/{category}/tutoriels', [TutorialsController::class, 'getByCategory'])->name('tutorials.category');
// Route::post('tutoriels/{id}/review', [TutorialsController::class, 'addReview'])->name('tutorials.review');
// Route::get('tutoriels/review/{id}/edit', [TutorialsController::class, 'editReview'])->name('tutorials.review.edit');
// Route::post('tutoriels/review/{id}/edit', [TutorialsController::class, 'updateReview'])->name('tutorials.review.update');
// Route::get('tutoriels/review/{id}/delete', [TutorialsController::class, 'deleteReview'])->name('tutorials.review.delete');

export default [
    {
        path: "/tutoriels",
        component: require("../../../components/tutorials/Tutorials").default,
        meta: {
            breadcrumb: "Tutorials",
        },
        children: [
            {
                name: "tutorials.index",
                path: "",
                component:
                    require("../../../components/tutorials/TutorialsIndex")
                        .default,
                meta: {
                    enterClass: "animate__animated animate__fadeInLeft",
                    leaveClass: "animate__animated animate__fadeOutRight",
                },
            },
            {
                name: "tutorials.show",
                path: ":slug",
                component: require("../../../components/tutorials/TutorialShow")
                    .default,

                meta: {
                    enterClass: "animate__animated animate__fadeInRight",
                    leaveClass: "animate__animated animate__fadeOutLeft",
                    breadCrumb(route) {
                        const slug = route.params.slug;
                        return [
                            {
                                text: "Tutorials",
                                to: { name: "tutorials.index" },
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
                name: "tutorials.rating",
                path: ":tutorial_id/rating",
                component: require("../../../components/tutorials/TutorialShow")
                    .default,
                meta: {
                    breadcrumb: "Tutorial",
                },
            },
            {
                name: "tutorials.review",
                path: ":id/review",
                component: require("../../../components/tutorials/TutorialShow")
                    .default,
                meta: {
                    breadcrumb: "Tutorial",
                },
            },
            {
                name: "tutorials.review.edit",
                path: "review/:id/edit",
                component: require("../../../components/tutorials/TutorialShow")
                    .default,
                meta: {
                    breadcrumb: "Tutorial",
                },
            },
            {
                name: "tutorials.review.update",
                path: "review/:id/edit",
                component: require("../../../components/tutorials/TutorialShow")
                    .default,
                meta: {
                    breadcrumb: "Tutorial",
                },
            },
            {
                name: "tutorials.review.delete",
                path: "review/:id/delete",
                component: require("../../../components/tutorials/TutorialShow")
                    .default,
                meta: {
                    breadcrumb: "Tutorial",
                },
            },
        ],
    },
];
