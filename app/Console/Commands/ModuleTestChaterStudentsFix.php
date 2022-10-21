<?php

namespace App\Console\Commands;

use App\Models\Module;
use App\Models\Test;
use Illuminate\Console\Command;

class ModuleTestChaterStudentsFix extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fix:module-test-formation';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Modules and Tests remove chapter student table';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $modules = Module::onlyTrashed()->get();
        foreach ($modules as $module) {
            $module->chapterStudents()->where('formation_id', $module->formation_id)->forceDelete();
        }

        $tests = Test::onlyTrashed()->get();
        foreach ($tests as $test) {
            $tests->chapterStudents()->where('formation_id', $test->formation_id)->forceDelete();
        }
    }
}
