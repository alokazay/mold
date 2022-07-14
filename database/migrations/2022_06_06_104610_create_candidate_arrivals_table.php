<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('candidate_arrivals', function (Blueprint $table) {
            $table->id();
            $table->string('candidate_id');
            $table->timestamp('date_arrive')->nullable();
            $table->integer('place_arrive_id')->nullable();
            $table->integer('transport_id')->nullable();
            $table->integer('status')->nullable();
            $table->integer('task_id')->nullable();
            $table->string('comment')->nullable();
            $table->char('file_id', 36)->nullable();
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
        Schema::dropIfExists('candidate_arrivals');
    }
};
