<?php

namespace Tests\Browser\admin\product;

use Tests\Browser\admin\AbstractDuskAdmin;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class EditProductTest extends AbstractDuskAdmin
{
    use DatabaseMigrations;

    /**
     * @test
     * @group product
     * @group admin
     */
    public function it_must_be_able_to_create_a_product()
    {
        $user = $this->addUser(true);
        $this->addProduct();
        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit('admin/products')
                ->assertSee('Products Page')
                ->pause('2000')
                ->pressAndWaitFor('Edit Product', ['seconds' => 2])
                ->assertSee('Edit Product')
                ->type('title', 'Candy')
                ->press('Edit')
                ->pause(2000)
                ->assertSee('You have updated the product!');
            $this->assertDatabaseHas('products', [
                'title' => 'Candy'
            ]);
        });
    }
}
