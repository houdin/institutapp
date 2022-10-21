//==============Quotation Routes =========================//
// Route::get('devis/{stage}', [QuotationsController::class, 'index'])->name('quotation');

export default [
    {
        path: "/devis/type",
        component: require("../../../components/quotation/QuotationType")
            .default,
    },
    {
        path: "/devis/personal-information",
        component:
            require("../../../components/quotation/QuotationPersonalInformation")
                .default,
    },
];
