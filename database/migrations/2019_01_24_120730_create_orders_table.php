<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id()->unsigned();
            $table->integer('user_id')->unsigned();
            $table->string('reference_no');
            $table->foreignId('address_id')->nullable()->constrained('addresses')->onDelete('cascade');;
            $table->date('order_date')->default(\Carbon\Carbon::now());
            $table->date('ship_date')->nullable();
            $table->decimal('total')->nullable();
            $table->decimal('sub_total')->nullable();
            $table->decimal('taxes')->nullable();
            $table->float('amount');
            $table->boolean('paid_for')->default(false);
            $table->boolean('shipped')->default(false);
            $table->integer('payment_type')->default(0)->comment('1-stripe/card, 2 - Paypal, 3 - Offline');
            $table->integer('status')->default(0)->comment('0 - in progress, 1 - Completed');
            // $table->foreign('address_id')
            //     ->references('id')
            //     ->on('addresses')
            //     ->onDelete('cascade');
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
        Schema::dropIfExists('orders');
    }
}
