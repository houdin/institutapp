//==============Portfolio Routes==========================//
// Route::get('portfolio', [PortfolioController::class, 'index'])->name('portfolios.all');
// Route::get('portfolio/{slug}', [PortfolioController::class, 'show'])->name('portfolios.show');
// //Route::post('formation/payment', [FormationsController::class, 'payment'])->name('formations.payment');
// Route::post('portfolio/{portfolio_id}/rating', [PortfolioController::class, 'rating'])->name('portfolios.rating');
// Route::get('category/{category}/portfolios', [PortfolioController::class, 'getByCategory'])->name('portfolios.category');

export default [
    {
        path: "/portfolio",
        component: require("../../../components/portfolios/Portfolios").default,
        children: [
            {
                name: "portfolios.index",
                path: "",
                component:
                    require("../../../components/portfolios/PortfoliosIndex")
                        .default,
            },
            {
                name: "portfolios.show",
                path: ":slug",
                component:
                    require("../../../components/portfolios/PortfolioShow")
                        .default,
            },
        ],
    },

    // {
    //     name: "portfolios.rating",
    //     path: "/portfolio/:portfolio_id/rating",
    //     component: require("../../../components/portfolios/QuotationPersonalInformation")
    //         .default
    // },
    // {
    //     name: "portfolios.category",
    //     path: "/category/:category/portfolios",
    //     component: require("../../../components/portfolios/QuotationPersonalInformation")
    //         .default
    // }
];
