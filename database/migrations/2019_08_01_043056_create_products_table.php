<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            // $table->integer('tax_id')->unsigned();
            $table->string('title');
            $table->string('slug');
            $table->decimal('price');
            // $table->foreignId('tax_id')->nullable()->constrained('taxes')->onDelete('cascade');
            $table->text('description')->nullable();
            $table->integer('vendor_id')->nullable();
            $table->float('weight')->nullable();
            $table->float('size')->nullable();
            $table->string('color')->nullable();
            $table->integer('discount')->nullable();
            $table->boolean('product_available')->default(0);
            $table->boolean('discount_available')->default(0);
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->boolean('published')->default(0);
            $table->tinyInteger('free')->default(0)->nullable();
            $table->text('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['deleted_at']);

            // $table->foreign('category_id')
            //     ->references('id')
            //     ->on('categories')
            //     ->onDelete('cascade');
            // $table->foreign('tax_id')
            //     ->references('id')
            //     ->on('taxes')
            //     ->onDelete('cascade');

            // $table->foreign('image_id')
            //     ->references('id')
            //     ->on('images')
            //     ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
