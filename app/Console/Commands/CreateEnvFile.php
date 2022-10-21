<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateEnvFile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'publish:env';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publishes the env file';

    /**
     * does teh env file already exist
     *
     * @var boolean
     */
    protected $envExists;

    /**
     * App settings
     *
     * @var array
     */
    protected $settings = [
        "APP_NAME=FXinstitut",
        "APP_ENV=local",
        "APP_KEY=",
        "APP_DEBUG=true",
        "APP_URL=http://fxinstitut.test",

        "LOG_CHANNEL=stack",
        "LOG_LEVEL=debug",

        "DB_CONNECTION=mysql",
        "DB_HOST=127.0.0.1",
        "DB_PORT=3306",
        "DB_DATABASE=fxinstitut",
        "DB_USERNAME=root",
        "DB_PASSWORD=",

        "BROADCAST_DRIVER=log",
        "CACHE_DRIVER=file",
        "QUEUE_CONNECTION=sync",
        "SESSION_DRIVER=file",
        "SESSION_LIFETIME=120",

        "MEMCACHED_HOST=127.0.0.1",

        "REDIS_HOST=127.0.0.1",
        "REDIS_PASSWORD=null",
        "REDIS_PORT=6379",

        "MAIL_MAILER=smtp",
        "MAIL_HOST=mailhog",
        "MAIL_PORT=1025",
        "MAIL_USERNAME=null",
        "MAIL_PASSWORD=null",
        "MAIL_ENCRYPTION=null",
        "MAIL_FROM_ADDRESS=null",
        'MAIL_FROM_NAME="${APP_NAME}"',

        "AWS_ACCESS_KEY_ID=",
        "AWS_SECRET_ACCESS_KEY=",
        "AWS_DEFAULT_REGION=us-east-1",
        "AWS_BUCKET=",

        "PUSHER_APP_ID=",
        "PUSHER_APP_KEY=",
        "PUSHER_APP_SECRET=",
        "PUSHER_APP_CLUSTER=mt1",

        'MIX_PUSHER_APP_KEY="${PUSHER_APP_KEY}"',
        'MIX_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"',

        "TAX_PRODUCT_PRICES=1",
        "TAX_SHIPPING_PRICES=1",
        "TAX_PRODUCT_DISPLAY_PRICES=1",
        "TAX_SHIPPING_DISPLAY_PRICES=1",
        "STRIPE_KEY=",
        "STRIPE_SECRET=",
        "ALGOLIA_APP_ID=",
        "ALGOLIA_SECRET=",
    ];

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->fileExists();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->envExists)
        {
            return;
        }
        $this->createFile();
        $this->line('An env.example file has been created.');
        $this->line("To use it in your project please rename the file .env");
    }

    /**
     * set if the file exists
     *
     * @return void
     */
    private function fileExists()
    {
        $this->envExists = file_exists('.env.example');
    }

    /**
     * create the env file
     *
     * @return void
     */
    private function createFile()
    {
        $myfile = fopen(".env.example", "w") or die("Unable to open file!");
        foreach ($this->settings as $setting)
        {
            fwrite($myfile, $setting . "\n");
        }
        fclose($myfile);
    }
}
