// Route::get('/boutique', [ShopController::class, 'index'])->name('shopping.shop');
//     Route::get('boutique/view-product/{slug}', [ProductsController::class, 'show'])->name('shopping.product.show');

//     // Search
//     Route::get('boutique/produit/{category}', [SearchController::class, 'category'])->name('shopping.search.product.category');
//     Route::post('boutique/produits', [SearchController::class, 'scout'])->name('shopping.search.products');
//     Route::get('boutique/produits/{search}', [SearchController::class, 'show'])->name('shopping.search.products.search');
//     Route::post('boutique/produits/api', [ApiSearchController::class, 'store'])->name('shopping.search.products.api');

export default [
    {
        name: "products.index",
        path: "/boutique",
        component: require("../../../components/products/ShopIndex").default,
    },
    {
        name: "products.show",
        path: "/boutique/product/:slug",
        component: require("../../../components/products/ShopProductShow")
            .default,
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
