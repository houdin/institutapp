// Route::get('contact', [ContactController::class, 'index'])->name('contact');
// Route::post('contact/send', [ContactController::class, 'send'])->name('contact.send');

export default [
    {
        path: "/contact",
        component: require("../../../components/contacts/Contact").default,
    },
];
