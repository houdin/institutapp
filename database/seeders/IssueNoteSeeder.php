<?php

namespace Database\Seeders;

use App\Models\IssueNote;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IssueNoteSeeder extends Seeder
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

        $this->truncate('issues_notes');

        IssueNote::factory(300)->create();

        $this->enableForeignKeys();
    }
}
