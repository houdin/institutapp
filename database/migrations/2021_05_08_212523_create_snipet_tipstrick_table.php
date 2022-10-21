<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSnipetTipstrickTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('snipet_tipstrick', function (Blueprint $table) {
            $table->foreignId('tipstrick_id')
                ->constrained('tipstricks')
                ->onDelete('cascade');

            $table->foreignId('snipet_id')
                ->constrained('snipets')
                ->onDelete('cascade');

            $table->primary(['tipstrick_id', 'snipet_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('snipet_tipstrick');
    }
}
