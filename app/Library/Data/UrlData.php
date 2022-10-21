<?php


namespace App\Library\Data;

use App\Http\Controllers\Frontend\Auth\LoginController;
use Illuminate\Support\Facades\URL;

use App\Http\Controllers\Frontend\Auth\RegisterValidationController;

class UrlData
{
    public static function get()
    {
        return [
            'appconfig' => route('app.config'),

            'index' => URL::to('/'),

            /// AUTH  /////////////////

            'login' => route('frontend.auth.login'),
            'logout' => route('frontend.auth.logout'),
            'register' => route('frontend.auth.register.post'),
            'teacher_register' => route('frontend.auth.teacher.register'),
            'register_confirm' => route('frontend.auth.account.confirm', ':token'),
            'register_confirm_resend' => route('frontend.auth.account.confirm.resend', ':uuid'),
            'password_reset' => route('frontend.auth.password.reset'),
            'user_email_url' => route('frontend.auth.register.user.email'),
            'user_username_url' => route('frontend.auth.register.user.username'),
            'users_details' => route('api.auth.user.details'),
            'users_roles' => route('api.auth.user.roles', [':cn', ':err']),
            'users_permissions' => route('api.auth.user.permissions', [':cn', ':err']),


            /// HOME  /////////////////

            'home_data' => route('home.data'),



            /// BLOG   /////////////////

            'blogs_category' => route('blogs.category', ':category'),
            'blogs_tag' => route('blogs.tag', ':tag'),
            'blogs_index' => route('blogs.index'),
            'blogs_show' => route('blogs.show', ':slug'),
            'blogs_comment' => route('blogs.comment', ':id'),
            'blogs_comment_delete' => route('blogs.comment.delete', ':id'),


            /// PREMIUM   /////////////////
            'premium_index' => route('premium.index', ':level'),


            /// TEACHERS   /////////////////
            'teachers_index' => route('teachers.index'),
            'teachers_show' => route('teachers.show', ':id'),


            /// FORMATIONS  ///////////////

            'formations_all' => route('formations.all'),
            'formations_show' => route('formations.show', ':slug'),
            'formations_rating' => route('formations.rating', ':formation_id'),
            'formations_category' => route('formations.category', ':category'),
            'formations_review' => route('formations.review', ':id'),
            'formations_review_edit' => route('formations.review.edit', ':id'),
            'formations_review_update' => route('formations.review.update', ':id'),
            'formations_review_delete' => route('formations.review.delete', ':id'),

            'formations_cartsession_elem' => route('formations.cartsession.elem', ':id'),

            'formations_purchased' => route('formations.purchased', ':formation_id'),


            /// QUOTATION  /////////////// _> AUTH

            'quotation' => route('quotation', ':stage'),

            /// MODULES  ///////////////  _> AUTH

            'modules_show' => route('modules.show', [':formation_id', ':slug']),
            'modules_test' => route('modules.test', [':slug']),
            'modules_retest' => route('modules.retest', [':slug']),

            'modules_question_result' => route('modules.question.result', [':question_id', ':result_id']),
            'modules_option_result' => route('modules.option.result', [':option_id', ':result_id']),
            'modules_media_progress' => route('modules.media.progress', [':media_id']),

            'update_videos_progress' => route('update.videos.progress'),
            'update_formation_progress' => route('update.formation.progress'),


            /// TUTORIALS  /////////////////

            'tutorials_all' => route('tutorials.all'),
            'tutorials_show' => str_replace('/:slug', '', route('tutorials.show', [':slug'])),
            'tutorials_rating' => str_replace('/:tutorial_id/rating', '', route('tutorials.rating', [':tutorial_id'])),
            'tutorials_category' => str_replace('/:category/tutoriels', '', route('tutorials.category', [':category'])),
            'tutorials_review' => str_replace('/:id/review', '', route('tutorials.review', [':id'])),
            'tutorials_review_edit' => str_replace('/:id/edit', '', route('tutorials.review.edit', ':id')),
            'tutorials_review_update' => str_replace('/:id/edit', '', route('tutorials.review.update', ':id')),
            'tutorials_review_delete' => str_replace('/:id/delete', '', route('tutorials.review.delete', ':id')),



            /// TIPS TRICKS  /////////////////

            'tipstricks_all' => route('tipstricks.all'),
            'tipstricks_show' => str_replace('/:slug', '', route('tipstricks.show', [':slug'])),
            'tipstricks_rating' => str_replace('/:tipstrick_id/rating', '', route('tipstricks.rating', [':tipstrick_id'])),
            'tipstricks_category' => str_replace('/:category/tips-tricks', '', route('tipstricks.category', [':category'])),



            /// PORTFOLIO  ///////////////////

            'portfolios_all' => route('portfolios.all'),
            'portfolios_show' => str_replace('/:slug', '', route('portfolios.show', [':slug'])),
            'portfolios_rating' => str_replace('/:portfolio_id/rating', '', route('portfolios.show', [':portfolio_id'])),
            'portfolios_category' => str_replace('/:category/portfolios', '', route('portfolios.category', [':category'])),


            /// BUNDLE  ///////////////////

            'bundles_all' => route('bundles.all'),
            'bundles_show' => str_replace('/:slug', '', route('bundles.show', ':slug')),
            'bundles_rating' => str_replace('/:bundle_id/rating', '', route('bundles.rating', ':bundle_id')),
            'bundles_category' => str_replace('/:category/bundles', '', route('bundles.category', ':category')),
            'bundles_review' => str_replace('/:id/review', '', route('bundles.review', ':id')),
            'bundles_review_edit' => str_replace('/:id/edit', '', route('bundles.review.edit', ':id')),
            'bundles_review_update' => str_replace('/:id/edit', '', route('bundles.review.update', ':id')),
            'bundles_review_delete' => str_replace('/:id/delete', '', route('bundles.review.delete', ':id')),


            /// SEARCH  ///////////////////

            // Route::get('/search', [HomeController::class, 'searchFormation'])->name('search');
            'search' => route('search'),
            // Route::get('/search-formation', [HomeController::class, 'searchFormation'])->name('search-formation');
            // Route::get('/search-bundle', [HomeController::class, 'searchBundle'])->name('search-bundle');
            // Route::get('/search-blog', [HomeController::class, 'searchBlog'])->name('blogs.search');


            /// FAQS  ///////////////////

            'faqs_all' => route('faqs'),


            ///  CONTACT  ///////////////////

            'contact' => route('contact'),
            'contact_send' => route('contact.send'),

            ///  DOWNLOAD  ///////////////////

            'download' => route('download'),


            ///  CART  ///////////////////


            ///  CART  ///////////////////


            // Route::resource('user/address', AddressController::class);

            'user_states' => route('api.auth.user.states'),
            'user_account' => route('api.auth.user.account'),
            'user_account_order' => str_replace('/:id', '', route('api.auth.user.account.order', [':id'])),

            'address_url' => route('api.auth.address.index'),
            'shopping_order_add_api' => route('shopping.order.add.api'),
            'shopping_order_billing_post' => route('shopping.order.billing.post'),


            'products_all' => route('products.all'),
            'products_show' => str_replace('/:slug', '', route('products.show', [':slug'])),

            'shopping_search_products' => route('shopping.search.products'),
            'shopping_search_products_search' => str_replace('/:search', '', route('shopping.search.products.search', [':search'])),
            'shopping_search_products_api' => route('shopping.search.products.api'),

            'shopping_search_product_category' => str_replace('/:category', '', route('shopping.search.product.category', [':category'])),

            'cart_getnow' => route('cart.getnow'),
            'cart_addToCard' => route('cart.addToCart'),
            'cart_checkout' => route('cart.checkout'),

            'shopping_cart' => route('shopping.cart'),
            'shopping_cart_add' => route('shopping.cart.add'),
            'shopping_cart_delete' => route('shopping.cart.destroy'),
            'shopping_cart_update' => route('shopping.cart.update'),

            'lang' => route('assets.lang'),




            'admin_dashboard' => route('admin.dashboard'),

            'admin_certificates_index' => route('admin.certificates.index'),
            'admin_certificates_generate' => route('admin.certificates.generate'),
            'admin_certificates_download' => route('admin.certificates.download')
        ];
    }
}
