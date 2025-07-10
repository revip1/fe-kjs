<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHpsHeadersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hps_headers', function (Blueprint $table) {
            $table->id();
            $table->string('cargo_name');
            $table->string('consignee');
            $table->string('vessel_name');
            $table->string('tonase');
            $table->string('jumlah_gang');
            $table->string('ldrate');
            $table->string('hari');
            $table->string('shift');
            $table->string('jam');
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
        Schema::dropIfExists('hps_headers');
    }
}
