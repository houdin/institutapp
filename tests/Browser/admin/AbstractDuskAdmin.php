<?php

namespace Tests\Browser\admin;

use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use App\Models\Auth\Role;
use App\Models\Sale;
use App\Models\Tax;
use App\Models\Auth\User;
use Tests\Browser\AbstractBrowser;
use Tests\Browser\AbstractBrowswerTest;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AbstractDuskAdmin extends AbstractBrowser
{
}
