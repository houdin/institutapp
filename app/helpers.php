<?php

use App\Helpers\General\Timezone;
use App\Helpers\General\HtmlHelper;

use function PHPUnit\Framework\returnSelf;

/*
 * Global helpers file with misc functions.
 */

if (!function_exists('app_name')) {
    /**
     * Helper to grab the application name.
     *
     * @return mixed
     */
    function app_name()
    {
        return config('app.name');
    }
}

if (!function_exists('gravatar')) {
    /**
     * Access the gravatar helper.
     */
    function gravatar()
    {
        return app('gravatar');
    }
}

if (!function_exists('timezone')) {
    /**
     * Access the timezone helper.
     */
    function timezone()
    {
        return resolve(Timezone::class);
    }
}

if (!function_exists('include_route_files')) {

    /**
     * Loops through a folder and requires all PHP files
     * Searches sub-directories as well.
     *
     * @param $folder
     */
    function include_route_files($folder)
    {
        try {
            $rdi = new recursiveDirectoryIterator($folder);
            $it = new recursiveIteratorIterator($rdi);

            while ($it->valid()) {
                if (!$it->isDot() && $it->isFile() && $it->isReadable() && $it->current()->getExtension() === 'php') {
                    require $it->key();
                }

                $it->next();
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}

if (!function_exists('home_route')) {

    /**
     * Return the route to the "home" page depending on authentication/authorization status.
     *
     * @return string
     */
    function home_route()
    {
        if (auth()->check()) {
            if (auth()->user()->can('view backend') && auth()->user()->isAdmin()) {
                return 'admin.dashboard';
            } else {
                return 'frontend.index';
            }
        }

        return 'frontend.index';
    }
}

if (!function_exists('style')) {

    /**
     * @param       $url
     * @param array $attributes
     * @param null $secure
     *
     * @return mixed
     */
    function style($url, $attributes = [], $secure = null)
    {
        return resolve(HtmlHelper::class)->style($url, $attributes, $secure);
    }
}

if (!function_exists('script')) {

    /**
     * @param       $url
     * @param array $attributes
     * @param null $secure
     *
     * @return mixed
     */
    function script($url, $attributes = [], $secure = null)
    {
        return resolve(HtmlHelper::class)->script($url, $attributes, $secure);
    }
}

if (!function_exists('form_cancel')) {

    /**
     * @param        $cancel_to
     * @param        $title
     * @param string $classes
     *
     * @return mixed
     */
    function form_cancel($cancel_to, $title, $classes = 'btn btn-danger ')
    {
        return resolve(HtmlHelper::class)->formCancel($cancel_to, $title, $classes);
    }
}

if (!function_exists('form_submit')) {

    /**
     * @param        $title
     * @param string $classes
     *
     * @return mixed
     */
    function form_submit($title, $classes = 'btn btn-success pull-right')
    {
        return resolve(HtmlHelper::class)->formSubmit($title, $classes);
    }
}

if (!function_exists('camelcase_to_word')) {

    /**
     * @param $str
     *
     * @return string
     */
    function camelcase_to_word($str)
    {
        return implode(' ', preg_split('/
          (?<=[a-z])
          (?=[A-Z])
        | (?<=[A-Z])
          (?=[A-Z][a-z])
        /x', $str));
    }
}

if (!function_exists('contact_data')) {

    /**
     * @param $str
     *
     * @return array
     */
    function contact_data($str)
    {
        $newElements = [];
        $elements = json_decode($str);
        foreach ($elements as $key => $item) {
            $newElements[$item->name] = ['value' => $item->value, 'status' => $item->status];
        }
        return $newElements;
    }
}

if (!function_exists('section_filter')) {

    /**
     * @param $str
     * Filter according to type selected.
     * 1 = Popular Categories
     * 2 = Featured Formation
     * 3 = Trending Formations
     * 4 = Popular Formations
     * 5 = Custom Links
     * @return array
     */
    function section_filter($section)
    {
        $type = $section->type;
        $section_data = "";
        $section_title = "";
        $content = [];

        if ($type == 1) {
            $section_content = \App\Models\Category::has('formations', '>', 7)
                ->where('status', '=', 1)->get()->take(6);
            $section_title = trans('labels.frontend.footer.popular_categories');
            foreach ($section_content as $item) {
                $single_item = [
                    'label' => $item->name,
                    'link' => route('formations.category', ['category' => $item->slug])
                ];
                $content[] = $single_item;
            }
        } else if ($type == 2) {
            $section_content = \App\Models\Formation::where('featured', '=', 1)
                ->has('category')
                ->where('published', '=', 1)
                ->orderBy('created_at', 'desc')
                ->take(6)
                ->get();
            $section_title = trans('labels.frontend.footer.featured_formations');
            foreach ($section_content as $item) {
                $single_item = [
                    'label' => $item->title,
                    'link' => route('formations.show', [$item->slug])
                ];
                $content[] = $single_item;
            }
        } else if ($type == 3) {
            $section_content = \App\Models\Formation::where('trending', '=', 1)
                ->has('category')
                ->where('published', '=', 1)
                ->orderBy('created_at', 'desc')
                ->take(6)
                ->get();
            $section_title = trans('labels.frontend.footer.trending_formations');
            foreach ($section_content as $item) {
                $single_item = [
                    'label' => $item->title,
                    'link' => route('formations.show', [$item->slug])
                ];
                $content[] = $single_item;
            }
        } else if ($type == 4) {
            $section_content = \App\Models\Formation::where('popular', '=', 1)
                ->has('category')
                ->where('published', '=', 1)
                ->orderBy('created_at', 'desc')
                ->take(6)
                ->get();
            $section_title = trans('labels.frontend.footer.popular_formations');
            foreach ($section_content as $item) {
                $single_item = [
                    'label' => $item->title,
                    'link' => route('formations.show', [$item->slug])
                ];
                $content[] = $single_item;
            }
        } else if ($type == 5) {
            $section_title = trans('labels.frontend.footer.useful_links');
            $section_content = $section->links;
            foreach ($section_content as $item) {
                $single_item = [
                    'label' => $item->label,
                    'link' => $item->link
                ];
                $content[] = $single_item;
            }
        }

        return ['section_content' => $content, 'section_title' => $section_title];
    }
}


if (!function_exists('generateInvoice')) {

    function generateInvoice($order)
    {
        $invoice = new \App\Http\Controllers\Traits\InvoiceGenerator();
        $invoice->number($order->id);

        foreach ($order->items as $item) {
            $title = $item->item->title;
            $price = $item->item->price;
            $qty = 1;
            $id = 'prod-' . $item->item->id;
            $invoice->addItem($title, $price, $qty, $id);
        }
        //        $invoice->number($order->id);
        $total = $order->items->sum('price');
        $coupon = \App\Models\Coupon::find($order->coupon_id);

        if ($coupon != null) {
            $discount =  $order->items->sum('price') * $coupon->amount / 100;
            $invoice->addDiscountData($discount);
            $total = $total - $discount;
        }
        $taxes = \App\Models\Tax::where('status', '=', 1)->get();
        $rateSum = \App\Models\Tax::where('status', '=', 1)->sum('rate');
        if ($taxes != null) {
            $taxData = [];
            foreach ($taxes as $tax) {

                $taxData[] = ['name' => $tax->name, 'amount' => $total * $tax->rate / 100];
            }
            $invoice->addTaxData($taxData);
            $total =  $total + ($total * $rateSum / 100);
        }
        $invoice->addTotal($total);
        $invoice->currency('XOF');
        $user = \App\Models\Auth\User::find($order->user_id);
        // dd(public_path());
        $invoice->customer(
            [
                'name' => $user->full_name,
                'id' => $user->id,
                'email' => $user->email
            ]
        )
            ->save('public/invoices/invoice-' . $order->id . '.pdf');
        // dd($invoice);
        //                ->download('invoice-'.$order->id.'.pdf');
        //                ->show('invoice-'.$order->id.'.pdf');


        $invoiceEntry = \App\Models\Invoice::where('order_id', '=', $order->id)->first();
        if ($invoiceEntry == "") {
            $invoiceEntry = new \App\Models\Invoice();
            $invoiceEntry->user_id = $order->user_id;
            $invoiceEntry->order_id = $order->id;
            $invoiceEntry->url = 'invoice-' . $order->id . '.pdf';
            $invoiceEntry->save();
        }
    }
}

if (!function_exists('trashUrl')) {

    /**
     * @param $str
     *
     * @return array
     */
    function trashUrl($request)
    {
        $currentQueries = $request->query();

        //Declare new queries you want to append to string:
        $newQueries = ['show_deleted' => 1];

        //Merge together current and new query strings:
        $allQueries = array_merge($currentQueries, $newQueries);

        //Generate the URL with all the queries:
        return $request->fullUrlWithQuery($allQueries);
    }
}

if (!function_exists('getCurrency')) {

    /**
     * @param $str
     *
     * @return array
     */
    function getCurrency($short_code)
    {
        $currencies = config('currencies');
        $currency = "";
        foreach ($currencies as $key => $val) {
            if ($val['short_code'] == $short_code) {
                $currency = $val;
            }
        }
        return $currency;
    }
}

if (!function_exists('menuList')) {


    function menuList($array)
    {
        // dd($array);
        $temp_array = array();
        foreach ($array as $item) {
            if ($item->getsons($item->id)->except($item->id)) {
                $item->subs = menuList($item->getsons($item->id)->except($item->id)); // here is the recursion
                $temp_array[] = $item;
            }
        }
        return $temp_array;
    }
}

if (!function_exists('categoriesMenu')) {

    function categoriesMenu($categories)
    {
        $menu = '<ul class="nav nav-pills nav-stacked">';

        foreach ($categories as $category) {
            $menu .= '<li>';
            $menu .= '<a href="/' . config('chatter.routes.home') . '/' . config('chatter.routes.category') . '/' . $category['slug'] . '">';
            $menu .= '<div class="chatter-box" style="background-color:' . $category['color'] . '"></div>';
            $menu .= $category['name'] . '</a>';

            if ($category['parents'] && count($category['parents'])) {
                $menu .= categoriesMenu($category['parents']);
            }

            $menu .= '</li>';
        }

        $menu .= '</ul>';

        return $menu;
    }
}


if (!function_exists('get_image_size')) {

    function get_image_size($num_size = null, $switcher = false)
    {
        //50
        //120x90
        //295x260
        //350x350
        //400x200
        //690x260
        $size = '';

        switch ($num_size) {
            case 1:
                $size = '400x290';
                break;
            case 2:
                $size = '540x850';
                break;
            case 3:
                $size = '750x410';
                break;
            case 4:
                $size = '1350x750';
                break;
            case 5:
                $size = '1850x900';
                break;
            case null:
                $size = '';
                break;
        }

        if ($switcher == true) {
            return explode('x', $size);
        } elseif ($switcher == false && $num_size != null) {
            return '-' . $size;
        }

        return $size;
    }
}

if (!function_exists('featured_image')) {

    function featured_image($item, $num_size = null)
    {

        $date = $item->created_at->format('y/m/');

        $extension = last(explode('.', $item->image->name));
        $name = head(explode('.', $item->image->name));

        return $date . $name . get_image_size($num_size) . '.' . $extension;
    }
}

if (!function_exists('featured_image_url')) {


    function featured_image_url($item, $num_size = null)
    {

        $extension = last(explode('.', $item->image->name));
        $name = head(explode('.', $item->image->name));

        $name_size = $name . get_image_size($num_size) . '.' . $extension;

        $url = str_replace($item->image->file_name, $name_size, $item->image->url);

        return $url;
    }
}

if (!function_exists('model_abbreviation')) {


    function model_abbreviation($item)
    {
        $abbrev = '';

        switch ($item) {
            case 'formation':
                $abbrev = 'fmt';
                break;
            case 'tutorial':
                $abbrev = 'ttl';
                break;
            case 'bundle':
                $abbrev = 'bdl';
                break;
            case 'portfolio':
                $abbrev = 'pfo';
                break;
            case 'product':
                $abbrev = 'pdt';
                break;
            case 'blog':
                $abbrev = 'blg';
                break;
            case 'tipstrick':
                $abbrev = 'tpt';
                break;
            case 'slider':
                $abbrev = 'sld';
                break;
            case 'slider':
                $abbrev = 'sld';
                break;
            case null:
                $size = '';
                break;
        }

        $extension = last(explode('.', $item->image->name));
        $name = head(explode('.', $item->image->name));

        $name_size = $name . get_image_size($num_size) . '.' . $extension;

        $url = str_replace($item->image->file_name, $name_size, $item->image->url);

        return $url;
    }
}


if (!function_exists('make_storage_dir')) {


    function make_storage_dir()
    {
        $now_year = date('/Y');
        $now_month = date('/m');

        if (!file_exists(public_path('storage/uploads'))) {
            mkdir(public_path('storage/uploads'), 0777);
            // mkdir(public_path('storage/upload/thumb'), 0777);
        }
        if (!file_exists(public_path('storage/uploads/images'))) {
            mkdir(public_path('storage/uploads/images'), 0777);
            // mkdir(public_path('storage/upload/thumb'), 0777);
        }
        if (!file_exists(public_path('storage/uploads/images' . $now_year))) {
            mkdir(public_path('storage/uploads/images' . $now_year), 0777);
        }
        if (!file_exists(public_path('storage/uploads/images' . $now_year . $now_month))) {
            mkdir(public_path('storage/uploads/images' . $now_year . $now_month), 0777);
        }
        if (!file_exists(public_path('storage/uploads/images' . $now_year . $now_month . '/origin'))) {
            mkdir(public_path('storage/uploads/images' . $now_year . $now_month . '/origin'), 0777);
        }
        if (!file_exists(public_path('storage/uploads/images' . $now_year . $now_month . '/resizing'))) {
            mkdir(public_path('storage/uploads/images' . $now_year . $now_month . '/resizing'), 0777);
        }
    }
}
