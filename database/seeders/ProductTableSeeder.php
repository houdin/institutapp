<?php

namespace Database\Seeders;

use App\Http\Traits\FileUploadTrait;
use App\Models\Image;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class ProductTableSeeder extends Seeder
{

    use FileUploadTrait;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // factory('App\Models\Product', 50)->create();
        $products = \App\Library\Data\FetchJsonFile::open('products.json');

        foreach ($products as $product) {

            $category = \App\Models\Category::inRandomOrder()->first();
            $supplier = \App\Models\Supplier::inRandomOrder()->first();
            $tax = \App\Models\Tax::inRandomOrder()->first();

            $name = 'product_' . rand(1, 10) . '.jpg';

            $extension = 'jpg';

            $this->saveFileSeeder(public_path('images/products/' . $name), $product['name']);

            // $head = head(explode('.', $this->placeholder[rand(0, 4)]));

            $file_name = Str::slug($product['name']);


            $image = Image::create([
                'name' => $name,
                'file_name' => $file_name,
                'url' => '/storage/uploads/images/' . date('Y/') . date('m/') . 'origin/' . $file_name . '.' . $extension,
                'extension' => $extension
            ]);

            $product = Product::create([
                'title' => $product['name'],
                'slug' => Str::slug($product['name']),
                // 'image_id' => $image->id,
                'category_id' => $category->id,
                // 'tax_id' => $tax->id,
                'price' => $product['price'],
                'weight' => $product['weight'],
                'description' => $product['description'],
                'vendor_id' => $supplier->id,
                'published' => rand(0, 1)
            ]);

            $product->image()->save($image);
        }
    }
}
