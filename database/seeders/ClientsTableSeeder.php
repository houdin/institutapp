<?php

namespace Database\Seeders;

use App\Models\Client;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;


class ClientsTableSeeder extends Seeder
{

    use \Database\Seeders\Traits\DisableForeignKeys;
    use \Database\Seeders\Traits\TruncateTable;

    public function run()
    {

        $this->disableForeignKeys();

        $this->truncate('clients');

        Client::factory(7)->create();

        $this->enableForeignKeys();
    }
}
