<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectusersTableSeeder extends Seeder
{
    use \Database\Seeders\Traits\DisableForeignKeys;
	use \Database\Seeders\Traits\TruncateTable;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->disableForeignKeys();

        foreach (\App\Models\Project::all() as $project){
            $project_count = \App\Models\Project::count();
            $projectUser = \App\Models\Projectuser::where('id','=', $project_count+1);
  
            \App\Models\Projectuser::create([
            
                'project_id' => $project->id,
                'user_id' => $project->user_id,
            ]);

        }

        $this->enableForeignKeys();
    }
}
