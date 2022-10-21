<?php


namespace App\Library\Transformer;


use Illuminate\Database\Eloquent\Model;

class PremiumsTransformer extends AbstractTransformer
{
    /**
     * returns a single product
     *
     * @param Model $model
     * @return array
     */
    public static function single(Model $model)
    {
        return [
            'product_id' => $model->id,
            'title' => $model->title,
            'price' => $model->price,
            'description' => $model->description,
            'weight' => $model->weight,
            'category' => $model->category()->first()->path,
            'image' => featured_image_url($model),
            'thumbnail' => featured_image_url($model, 2)
        ];
    }
}
