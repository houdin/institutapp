<?php

namespace Database\Seeders;

use App\Models\Question;
use App\Models\Formation;
use App\Models\QuestionsOption;
use Illuminate\Database\Seeder;

class QuestionsSeeder extends Seeder
{

    public $count = 30;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->count = Formation::count();

        Question::factory(500)->create()->each(function ($question) {

            $question->options()->saveMany(QuestionsOption::factory(4)->create());
            $question->tests()->attach(rand(1, $this->count));
        });
    }
}
