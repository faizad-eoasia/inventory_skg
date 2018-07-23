<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGlobalStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('global_status', function (Blueprint $table) {
            $table->increments('id');
            $table->string('table',30);
            $table->string('status',2);
            $table->longtext('description');
            $table->integer('created_by')->nullable()->comment('User ID');
            $table->integer('updated_by')->nullable()->comment('User ID');
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
        Schema::dropIfExists('global_status');
    }
}