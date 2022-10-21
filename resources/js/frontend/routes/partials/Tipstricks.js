//===============Tips and Tricks Routes==================//
// Route::get('tips-tricks', [TipstricksController::class, 'index'])->name('tipstricks.all');
// Route::get('tips-trick/{slug}', [TipstricksController::class, 'show'])->name('tipstrick.show');
// //Route::post('formation/payment', [FormationsController::class, 'payment'])->name('formations.payment');
// Route::post('tips-trick/{tipstrick_id}/rating', [TipstricksController::class, 'rating'])->name('tipstricks.rating');
// Route::get('category/{category}/tips-tricks', [TipstricksController::class, 'getByCategory'])->name('tipstrick.category');

export default [
    {
        name: "tipstricks.index",
        path: "/tips-tricks",
        component: require("../../../components/tipstricks/TipstricksIndex")
            .default,
    },
    {
        name: "tipstricks.show",
        path: "/tips-trick/:slug",
        component: require("../../../components/tipstricks/TipstrickShow")
            .default,
    },
];
