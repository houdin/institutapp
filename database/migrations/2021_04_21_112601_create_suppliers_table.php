<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('company')->nullable();
            $table->string('slug')->nullable();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('title')->nullable();
            $table->string('address')->nullable();
            $table->string('city');
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->string('phone');
            $table->string('email');
            $table->string('url')->nullable();
            $table->string('payment_methods');
            $table->integer('notes')->default(0);
            $table->string('logo')->nullable();
            $table->string('customer_id');
            $table->boolean('status')->default(1);
            $table->boolean('active')->default(0);

            $table->softDeletes();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('suppliers');
    }
}
