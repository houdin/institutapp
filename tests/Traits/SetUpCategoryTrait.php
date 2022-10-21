<?php

/**
 * Created by PhpStorm.
 * User: shawnlegge
 * Date: 10/8/17
 * Time: 10:36 AM
 */
trait SetUpCategoryTrait
{
    /**
     * @var \App\Models\Category
     */
    protected $category;

    /**
     * @var \Illuminate\Database\Eloquent\Collection
     */
    protected $categories;

    private $newCategories = ['electronics', 'furniture'];

    public function setUpCategory()
    {
        \App\Models\Category::truncate();
        $this->category = \App\Models\Category::create([
            'name'=> 'clothes'
        ]);
    }

    /**
     * add categories
     *
     * @return void
     */
    public function addCategories()
    {
        foreach ($this->newCategories as $category)
        {
            \App\Models\Category::create([
                'name'=> $category
            ]);
        }
        $this->categories = \App\Models\Category::all();
    }
}