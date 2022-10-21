<?php

namespace Database\Factories;

use App\Models\Module;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class ModuleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Module::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = $this->faker->sentence(8);
        return [
            'title' => $name,
            'slug' => Str::slug($name),
            'short_text' => $this->faker->paragraph(),
            'full_text' => $this->faker->text(1000),
            'position' => rand(1, 10),
            'free_module' => 1,
            'published' => rand(0, 1),
        ];
    }
}
