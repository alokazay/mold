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
        Schema::create('c_files', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('type');
            $table->integer('autor_id');
            $table->integer('user_id');
            $table->string('path');
            $table->string('original_name');
            $table->string('ext');
            $table->string('name')->nullable();
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
        Schema::dropIfExists('c_files');
    }
};
