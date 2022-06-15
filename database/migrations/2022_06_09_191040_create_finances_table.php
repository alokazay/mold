<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('finances', function (Blueprint $table) {
            $table->id();
            $table->integer('amount');
            $table->integer('user_id');
            $table->integer('firm_id');
            $table->integer('status');
            $table->integer('type_request_id')->nullable();
            $table->char('file_id', 36)->nullable();
            $table->timestamp('date_request')->nullable();
            $table->timestamp('date_payed')->nullable();
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
        Schema::dropIfExists('finances');
    }
};
