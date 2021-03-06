<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgentAddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agent_address', function (Blueprint $table) {
            $table->increments('id');
            $table->string('address_code', 20);
            $table->string('name', 20);
            $table->string('street1', 255);
            $table->string('street2', 255)->nullable();
            $table->integer('poscode');
            $table->string('city', 100);
            $table->string('state', 100);
            $table->string('country', 100);
            $table->string('reminder_flag',5);
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
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
        Schema::dropIfExists('agent_address');
    }
}
