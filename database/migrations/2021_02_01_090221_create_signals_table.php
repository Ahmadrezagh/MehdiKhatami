<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSignalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('signals', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('exchange_id')->unsigned()->nullable()->default(null);
            $table->bigInteger('signal_type_id')->unsigned()->nullable()->default(null);
            $table->bigInteger('result_id')->unsigned()->nullable()->default(null);
            $table->bigInteger('command_id')->unsigned()->nullable()->default(null);
            $table->integer('duration')->default(0);
            $table->timestamps();

            $table->foreign('exchange_id')->references('id')->on('exchanges')->onDelete('cascade');
            $table->foreign('signal_type_id')->references('id')->on('signal_types')->onDelete('cascade');
            $table->foreign('result_id')->references('id')->on('results')->onDelete('cascade');
            $table->foreign('command_id')->references('id')->on('commands')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('signals');
    }
}
