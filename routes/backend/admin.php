<?php

namespace Routes\Backend;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\TaxController;

use App\Http\Controllers\Backend\CouponController;
use App\Http\Controllers\Backend\ReportController;
use App\Http\Controllers\Backend\ReviewController;

use App\Http\Controllers\Backend\ContactController;
use App\Http\Controllers\Backend\PaymentController;
use App\Http\Controllers\Backend\SitemapController;
use App\Http\Controllers\Backend\MessagesController;
use App\Http\Controllers\Backend\Admin\FaqController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\Admin\BlogController;
use App\Http\Controllers\Backend\Admin\ForumController;
use App\Http\Controllers\Backend\Admin\MediaController;
use App\Http\Controllers\Backend\Admin\OrderController;
use App\Http\Controllers\Backend\Admin\TestsController;
use App\Http\Controllers\Backend\CertificateController;
use App\Http\Controllers\Backend\Admin\ConfigController;

use App\Http\Controllers\Backend\Admin\SliderController;
use App\Http\Controllers\Backend\Admin\StatesController;
use App\Http\Controllers\Backend\Admin\InvoiceController;
use App\Http\Controllers\Backend\Admin\ModulesController;
use App\Http\Controllers\Backend\Admin\PremiumController;

use App\Http\Controllers\Backend\Admin\ProductsController;
use App\Http\Controllers\Backend\Admin\TeachersController;
use App\Http\Controllers\Backend\Admin\ApiClientController;
use App\Http\Controllers\Backend\Admin\PortfolioController;
use App\Http\Controllers\Backend\Admin\QuestionsController;
use App\Http\Controllers\Backend\Admin\StaffingsController;
use App\Http\Controllers\Backend\Admin\TutorialsController;
use App\Http\Controllers\Backend\Admin\CategoriesController;
use App\Http\Controllers\Backend\Admin\FormationsController;
use App\Http\Controllers\Backend\Admin\MediasController;
use App\Http\Controllers\Backend\Admin\QuotationsController;
use App\Http\Controllers\Backend\Admin\TipstricksController;
use App\Http\Controllers\Backend\Auth\User\AccountController;
use App\Http\Controllers\Backend\Auth\User\ProfileController;
use App\Http\Controllers\Backend\Admin\QuestionsOptionsController;
use App\Http\Controllers\Backend\Auth\User\UserPasswordController;
use App\Http\Controllers\Backend\Auth\User\UpdatePasswordController;
use App\Http\Controllers\ImageController;

/*
 * All route names are prefixed with 'admin.'.
 */

// Route::backlist(function () {


//===== General Routes =====//

// Route::redirect('/', '/user/dashboard', 301);

Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');


Route::group(['middleware' => 'role:teacher|administrator'], function () {
    Route::resource('orders', OrderController::class);
});
Route::group(['middleware' => 'role:administrator', 'namespace' => ''], function () {

    Route::post('app-img/colorset', [ImageController::class, 'update']);

    //===== Teachers Routes =====//
    Route::resource('teachers', TeachersController::class);
    Route::get('get-teachers-data', [TeachersController::class, 'getData'])->name('teachers.get_data');
    Route::post('teachers_mass_destroy', [TeachersController::class, 'massDestroy'])->name('teachers.mass_destroy');
    Route::post('teachers_restore/{id}', [TeachersController::class, 'restore'])->name('teachers.restore');
    Route::delete('teachers_perma_del/{id}', [TeachersController::class, 'perma_del'])->name('teachers.perma_del');
    Route::post('teacher/status', [TeachersController::class, 'updateStatus'])->name('teachers.status');


    //===== FORUMS Routes =====//
    Route::resource('forums-category', ForumController::class);
    Route::get('forums-category/status/{id}', [ForumController::class, 'status'])->name('forums-category.status');


    //===== Orders Routes =====//
    Route::get('get-orders-data', [OrderController::class, 'getData'])->name('orders.get_data');
    Route::post('orders_mass_destroy', [OrderController::class, 'massDestroy'])->name('orders.mass_destroy');
    Route::post('orders/complete', [OrderController::class, 'complete'])->name('orders.complete');
    Route::delete('orders_perma_del/{id}', [OrderController::class, 'perma_del'])->name('orders.perma_del');


    //===== Settings Routes =====//
    Route::get('settings/general', [ConfigController::class, 'getGeneralSettings'])->name('general-settings');

    Route::post('settings/general', [ConfigController::class, 'saveGeneralSettings'])->name('general-settings.save');

    Route::get('settings/social', [ConfigController::class, 'getSocialSettings'])->name('social-settings');

    Route::post('settings/social', [ConfigController::class, 'saveSocialSettings'])->name('social-settings.save');

    Route::get('contact', [ConfigController::class, 'getContact'])->name('contact-settings');

    Route::get('footer', [ConfigController::class, 'getFooter'])->name('footer-settings');

    Route::get('newsletter', [ConfigController::class, 'getNewsletterConfig'])->name('newsletter-settings');

    Route::post('newsletter/sendgrid-lists', [ConfigController::class, 'getSendGridLists'])->name('newsletter.getSendGridLists');


    //===== Slider Routes =====/
    Route::resource('sliders', SliderController::class);
    Route::get('sliders/status/{id}', [SliderController::class, 'status'])->name('sliders.status', 'id');
    Route::post('sliders/save-sequence', [SliderController::class, 'saveSequence'])->name('sliders.saveSequence');
    Route::post('sliders/status', [SliderController::class, 'updateStatus'])->name('sliders.status.update');


    //===== FAQs Routes =====//
    Route::resource('faqs', FaqController::class);
    Route::get('get-faqs-data', [FaqController::class, 'getData'])->name('faqs.get_data');
    Route::post('faqs_mass_destroy', [FaqController::class, 'massDestroy'])->name('faqs.mass_destroy');
    Route::get('faqs/status/{id}', [FaqController::class, 'status'])->name('faqs.status');
    Route::post('faqs/status', [FaqController::class, 'updateStatus'])->name('faqs.status.update');


    //====== Contacts Routes =====//
    Route::resource('contact-requests', ContactController::class);
    Route::get('get-contact-requests-data', [ContactController::class, 'getData'])->name('contact_requests.get_data');


    //====== Tax Routes =====//
    Route::resource('tax', TaxController::class);
    Route::get('tax/status/{id}', [TaxController::class, 'status'])->name('tax.status', 'id');
    Route::post('tax/status', [TaxController::class, 'updateStatus'])->name('tax.status.update');


    //====== Coupon Routes =====//
    Route::resource('coupons', CouponController::class);
    Route::get('coupons/status/{id}', [CouponController::class, 'status'])->name('coupons.status', 'id');
    Route::post('coupons/status', [CouponController::class, 'updateStatus'])->name('coupons.status.update');


    //==== Remove Locale FIle ====//
    Route::post('delete-locale', function () {
        \Barryvdh\TranslationManager\Models\Translation::where('locale', request('locale'))->delete();

        \Illuminate\Support\Facades\File::deleteDirectory(public_path('../resources/lang/' . request('locale')));
    })->name('delete-locale');



    //===Trouble shoot ====//
    Route::get('troubleshoot', [ConfigController::class, 'troubleshoot'])->name('troubleshoot');


    //==== API Clients Routes ====//
    Route::prefix('api-client')->group(function () {
        Route::get('all', [ApiClientController::class, 'all'])->name('api-client.all');
        Route::post('generate', [ApiClientController::class, 'generate'])->name('api-client.generate');
        Route::post('status', [ApiClientController::class, 'status'])->name('api-client.status');
    });


    //==== Sitemap Routes =====//
    Route::get('sitemap', [SitemapController::class, 'getIndex'])->name('sitemap.index');
    Route::post('sitemap', [SitemapController::class, 'saveSitemapConfig'])->name('sitemap.config');
    Route::get('sitemap/generate', [SitemapController::class, 'generateSitemap'])->name('sitemap.generate');


    // Route::post('translations/locales/add', [LangController::class, 'postAddLocale']);
    // Route::post('translations/locales/remove', [LangController::class, 'postRemoveLocaleFolder'])->name('delete-locale-folder');

});


//Common - Shared Routes for Teacher and Administrator
Route::group(['middleware' => 'role:administrator|teacher'], function () {

    //====== Reports Routes =====//
    Route::get('report/sales', [ReportController::class, 'getSalesReport'])->name('reports.sales');
    Route::get('report/students', [ReportController::class, 'getStudentsReport'])->name('reports.students');

    Route::get('get-formation-reports-data', [ReportController::class, 'getFormationData'])->name('reports.get_formation_data');
    Route::get('get-bundle-reports-data', [ReportController::class, 'getBundleData'])->name('reports.get_bundle_data');
    Route::get('get-students-reports-data', [ReportController::class, 'getStudentsData'])->name('reports.get_students_data');


    //====== Wallet  =====//
    Route::get('payments', [PaymentController::class, 'index'])->name('payments');
    Route::get('get-earning-data', [PaymentController::class, 'getEarningData'])->name('payments.get_earning_data');
    Route::get('get-withdrawal-data', [PaymentController::class, 'getwithdrawalData'])->name('payments.get_withdrawal_data');
    Route::get('payments/withdraw-request', [PaymentController::class, 'createRequest'])->name('payments.withdraw_request');
    Route::post('payments/withdraw-store', [PaymentController::class, 'storeRequest'])->name('payments.withdraw_store');
    Route::get('payments-requests', [PaymentController::class, 'paymentRequest'])->name('payments.requests');
    Route::get('get-payment-request-data', [PaymentController::class, 'getPaymentRequestData'])->name('payments.get_payment_request_data');
    Route::post('payments-request-update', [PaymentController::class, 'paymentsRequestUpdate'])->name('payments.payments_request_update');
});
//===== Portfolio Routes =====//
Route::resource('portfolio', PortfolioController::class);
Route::get('get-portfolio-data', [PortfolioController::class, 'getData'])->name('portfolio.get_data');
Route::post('portfolio_mass_destroy', [PortfolioController::class, 'massDestroy'])->name('portfolio.mass_destroy');
Route::post('portfolio_restore/{id}', [PortfolioController::class, 'restore'])->name('portfolio.restore');
Route::delete('portfolio_perma_del/{id}', [PortfolioController::class, 'perma_del'])->name('portfolio.perma_del');
Route::get('portfolio-publish/{id}', [PortfolioController::class, 'publish'])->name('portfolio.publish');

//===== Products Routes =====//
Route::resource('products', ProductsController::class);
Route::get('get-products-data', [ProductsController::class, 'getData'])->name('products.get_data');
Route::post('products_mass_destroy', [ProductsController::class, 'massDestroy'])->name('products.mass_destroy');
Route::post('products_restore/{id}', [ProductsController::class, 'restore'])->name('products.restore');
Route::delete('products_perma_del/{id}', [ProductsController::class, 'perma_del'])->name('products.perma_del');
Route::get('product-publish/{id}', [ProductsController::class, 'publish'])->name('products.publish');

//===== Categories Routes =====//
Route::resource('categories', CategoriesController::class);
Route::get('get-categories-data', [CategoriesController::class, 'getData'])->name('categories.get_data');
Route::post('categories_mass_destroy', [CategoriesController::class, 'massDestroy'])->name('categories.mass_destroy');
Route::post('categories_restore/{id}', [CategoriesController::class, 'restore'])->name('categories.restore');
Route::delete('categories_perma_del/{id}', [CategoriesController::class, 'perma_del'])->name('categories.perma_del');


//===== Quotations Routes =====//
Route::resource('quotations', QuotationsController::class);
Route::get('get-quotations-data', [QuotationsController::class, 'getData'])->name('quotations.get_data');
Route::post('quotations_mass_destroy', [QuotationsController::class, 'massDestroy'])->name('quotations.mass_destroy');
Route::post('quotations_restore/{id}', [QuotationsController::class, 'restore'])->name('quotations.restore');
Route::delete('quotations_perma_del/{id}', [QuotationsController::class, 'perma_del'])->name('quotations.perma_del');
Route::get('quotation-publish/{id}', [QuotationsController::class, 'publish'])->name('quotations.publish');

//===== Staffings Routes =====//
Route::resource('staffings', StaffingsController::class);
Route::get('get-staffings-data', [StaffingsController::class, 'getData'])->name('staffings.get_data');
Route::post('staffings_mass_destroy', [StaffingsController::class, 'massDestroy'])->name('staffings.mass_destroy');
Route::post('staffings_restore/{id}', [StaffingsController::class, 'restore'])->name('staffings.restore');
Route::delete('staffings_perma_del/{id}', [StaffingsController::class, 'perma_del'])->name('staffings.perma_del');
Route::get('staffing-publish/{id}', [StaffingsController::class, 'publish'])->name('staffings.publish');

//===== States Routes =====//
Route::resource('states', StatesController::class);
Route::get('get-states-data', [StatesController::class, 'getData'])->name('states.get_data');
Route::post('states_mass_destroy', [StatesController::class, 'massDestroy'])->name('states.mass_destroy');
Route::post('states_restore/{id}', [StatesController::class, 'restore'])->name('states.restore');
Route::delete('states_perma_del/{id}', [StatesController::class, 'perma_del'])->name('states.perma_del');
Route::get('state-publish/{id}', [StatesController::class, 'publish'])->name('states.publish');

//===== Premium Routes =====//
Route::resource('premium', PremiumController::class);
Route::get('get-premium-data', [PremiumController::class, 'getData'])->name('premium.get_data');
Route::post('premium_mass_destroy', [PremiumController::class, 'massDestroy'])->name('premium.mass_destroy');
Route::post('premium_restore/{id}', [PremiumController::class, 'restore'])->name('premium.restore');
Route::delete('premium_perma_del/{id}', [PremiumController::class, 'perma_del'])->name('premium.perma_del');
Route::get('premium-publish/{id}', [PremiumController::class, 'publish'])->name('premium.publish');

//===== Tipstricks Routes =====//
Route::resource('tips-tricks', TipstricksController::class);
Route::get('get-tips-tricks-data', [TipstricksController::class, 'getData'])->name('tipstricks.get_data');
Route::post('tips-tricks_mass_destroy', [TipstricksController::class, 'massDestroy'])->name('tipstricks.mass_destroy');
Route::post('tips-tricks_restore/{id}', [TipstricksController::class, 'restore'])->name('tipstricks.restore');
Route::delete('tips-tricks_perma_del/{id}', [TipstricksController::class, 'perma_del'])->name('tipstricks.perma_del');
Route::get('tips-trick-publish/{id}', [TipstricksController::class, 'publish'])->name('tipstricks.publish');

//===== Formations Routes =====//
Route::resource('formations', FormationsController::class);

Route::get('get-formations-data', [FormationsController::class, 'getData'])->name('formations.get_data');
Route::post('formations_mass_destroy', [FormationsController::class, 'massDestroy'])->name('formations.mass_destroy');
Route::post('formations_restore/{id}', [FormationsController::class, 'restore'])->name('formations.restore');
Route::delete('formations_perma_del/{id}', [FormationsController::class, 'perma_del'])->name('formations.perma_del');
Route::post('formation-save-sequence', [FormationsController::class, 'saveSequence'])->name('formations.saveSequence');
Route::get('formation-publish/{id}', [FormationsController::class, 'publish'])->name('formations.publish');

//===== Tutorials Routes =====//
Route::resource('tutorials', TutorialsController::class);
Route::get('get-tutorials-data', [TutorialsController::class, 'getData'])->name('tutorials.get_data');
Route::post('tutorials_mass_destroy', [TutorialsController::class, 'massDestroy'])->name('tutorials.mass_destroy');
Route::post('tutorials_restore/{id}', [TutorialsController::class, 'restore'])->name('tutorials.restore');
Route::delete('tutorials_perma_del/{id}', [TutorialsController::class, 'perma_del'])->name('tutorials.perma_del');
Route::post('tutorial-save-sequence', [TutorialsController::class, 'saveSequence'])->name('tutorials.saveSequence');
Route::get('tutorial-publish/{id}', [TutorialsController::class, 'publish'])->name('tutorials.publish');





//===== Modules Routes =====//
Route::resource('modules', ModulesController::class);
Route::get('get-modules-data', [ModulesController::class, 'getData'])->name('modules.get_data');
Route::post('modules_mass_destroy', [ModulesController::class, 'massDestroy'])->name('modules.mass_destroy');
Route::post('modules_restore/{id}', [ModulesController::class, 'restore'])->name('modules.restore');
Route::delete('modules_perma_del/{id}', [ModulesController::class, 'perma_del'])->name('modules.perma_del');

//===== Medias Routes =====//
Route::resource('medias', MediasController::class);
Route::get('get-medias-data', [MediasController::class, 'getData'])->name('medias.get_data');
Route::post('medias_mass_destroy', [MediasController::class, 'massDestroy'])->name('medias.mass_destroy');
Route::post('medias_restore/{id}', [MediasController::class, 'restore'])->name('medias.restore');
Route::delete('medias_perma_del/{id}', [MediasController::class, 'perma_del'])->name('medias.perma_del');


//===== Questions Routes =====//
Route::resource('questions', QuestionsController::class);
Route::get('get-questions-data', [QuestionsController::class, 'getData'])->name('questions.get_data');
Route::post('questions_mass_destroy', [QuestionsController::class, 'massDestroy'])->name('questions.mass_destroy');
Route::post('questions_restore/{id}', [QuestionsController::class, 'restore'])->name('questions.restore');
Route::delete('questions_perma_del/{id}', [QuestionsController::class, 'perma_del'])->name('questions.perma_del');


//===== Questions Options Routes =====//
Route::resource('questions_options', QuestionsOptionsController::class);
Route::get('get-qo-data', [QuestionsOptionsController::class, 'getData'])->name('questions_options.get_data');
Route::post('questions_options_mass_destroy', [QuestionsOptionsController::class, 'massDestroy'])->name('questions_options.mass_destroy');
Route::post('questions_options_restore/{id}', [QuestionsOptionsController::class, 'restore'])->name('questions_options.restore');
Route::delete('questions_options_perma_del/{id}', [QuestionsOptionsController::class, 'perma_del'])->name('questions_options.perma_del');


//===== Tests Routes =====//
Route::resource('tests', TestsController::class);
Route::get('get-tests-data', [TestsController::class, 'getData'])->name('tests.get_data');
Route::post('tests_mass_destroy', [TestsController::class, 'massDestroy'])->name('tests.mass_destroy');
Route::post('tests_restore/{id}', [TestsController::class, 'restore'])->name('tests.restore');
Route::delete('tests_perma_del/{id}', [TestsController::class, 'perma_del'])->name('tests.perma_del');


//===== Media Routes =====//
Route::post('media/remove', [MediaController::class, 'destroy'])->name('media.destroy');


//===== User Account Routes =====//
Route::group(['middleware' => ['auth', 'password_expires']], function () {
    Route::get('account', [AccountController::class, 'index'])->name('account');
    Route::patch('account/{email?}', [UserPasswordController::class, 'update'])->name('account.post');
    Route::patch('profile/update', [ProfileController::class, 'update'])->name('profile.update');
});


Route::group(['middleware' => 'role:teacher'], function () {
    //====== Review Routes =====//
    Route::resource('reviews', ReviewController::class);
    Route::get('get-reviews-data', [ReviewController::class, 'getData'])->name('reviews.get_data');
});


Route::group(['middleware' => 'role:student'], function () {

    //==== Certificates ====//
    Route::get('certificates', [CertificateController::class, 'getCertificates'])->name('certificates.index');
    Route::post('certificates/generate', [CertificateController::class, 'generateCertificate'])->name('certificates.generate');
    Route::get('certificates/download', [CertificateController::class, 'download'])->name('certificates.download');
});


//==== Messages Routes =====//
Route::get('messages', [MessagesController::class, 'index'])->name('messages');
Route::get('messages/unread', [MessagesController::class, 'getUnreadMessages'])->name('messages.unread');
Route::post('messages/send', [MessagesController::class, 'send'])->name('messages.send');
Route::post('messages/reply', [MessagesController::class, 'reply'])->name('messages.reply');

//=== Invoice Routes =====//
Route::get('invoice/download', [InvoiceController::class, 'getInvoice'])->name('invoice.download');
Route::get('invoices', [InvoiceController::class, 'getIndex'])->name('invoices.index');


//======= Blog Routes =====//
Route::group(['prefix' => 'blog'], function () {
    Route::get('/create', [BlogController::class, 'create']);
    Route::post('/create', [BlogController::class, 'store']);
    Route::get('delete/{id}', [BlogController::class, 'destroy'])->name('blog.delete');
    Route::get('edit/{id}', [BlogController::class, 'edit'])->name('blog.edit');
    Route::post('edit/{id}', [BlogController::class, 'update']);
    Route::get('view/{id}', [BlogController::class, 'show']);
    //        Route::get('{blog}/restore', [BlogController::class, 'restore'])->name('blog.restore');
    Route::post('{id}/storecomment', [BlogController::class, 'storeComment'])->name('storeComment');
});


Route::resource('blogs', BlogController::class);
Route::get('get-blogs-data', [BlogController::class, 'getData'])->name('blogs.get_data');
Route::post('blogs_mass_destroy', [BlogController::class, 'massDestroy'])->name('blogs.mass_destroy');
// });
