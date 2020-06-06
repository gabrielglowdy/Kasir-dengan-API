<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePuchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('puchases', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('grand_total');
            $table->integer('ppn');
            $table->integer('pembulatan');
            $table->integer('total');
            $table->integer('terbayar');
            $table->integer('kembalian')->nullable();
            $table->string('kasir');
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
        Schema::dropIfExists('puchases');
    }
}
