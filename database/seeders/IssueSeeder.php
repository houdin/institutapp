<?php

namespace Database\Seeders;

use App\Models\Issue;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IssueSeeder extends Seeder
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

        $this->truncate('issues');

        Issue::factory(300)->create();

        $this->enableForeignKeys();
    }
}
