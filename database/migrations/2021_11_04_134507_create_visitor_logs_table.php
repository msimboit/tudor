<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisitorLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visitor_logs', function (Blueprint $table) {
            $table->id();
            $table->integer('logger_id')->unsigned();
            $table->string('first_name');
            $table->string('last_name');
            $table->integer('id_number')->unsigned();
            $table->string('phone_number');
            $table->string('id_image')->nullable();
            $table->text('destination');
            $table->string('host');
            $table->boolean('has_vehicle')->nullable()->default(false);
            $table->string('vehicle_type')->nullable();
            $table->string('vehicle_number')->nullable();
            $table->string('vehicle_image')->nullable();
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
        Schema::dropIfExists('visitor_logs');
    }
}
