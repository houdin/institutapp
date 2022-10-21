//==============Quotation Routes =========================//
// Route::get('devis/{stage}', [QuotationsController::class, 'index'])->name('quotation');

export default [
    {
        path: "/order",
        component: require("../../../components/order/OrderPage").default,
        children: [
            {
                name: "edit_order",
                path: "edit-order",
                component: {
                    OrderInformation:
                        require("../../../components/order/confirm-cart/OrderInformation")
                            .default,
                },
            },
            {
                name: "select_address",
                path: "select-address",
                component: {
                    SelectUserAddress:
                        require("../../../components/order/address/SelectUserAddress")
                            .default,
                },
            },
            {
                name: "order_payment",
                path: "payment",
                component: {
                    OrderPayment:
                        require("../../../components/order/payment/OrderPayment")
                            .default,
                },
            },
            {
                name: "order_invoice",
                path: "invoice",
                component: {
                    UserOrder:
                        require("../../../components/order/invoice/UserOrder")
                            .default,
                },
            },
        ],
    },
];
