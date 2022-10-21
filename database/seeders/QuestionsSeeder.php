<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Question;
use App\Models\QuestionsOption;

class QuestionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Question::factory(500)->create()->each(function ($question) {
            $question->options()->saveMany(QuestionsOption::factory(4)->create());
            $question->tests()->attach(rand(1, 60));
        });
    }
}
