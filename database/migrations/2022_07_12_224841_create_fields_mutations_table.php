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
        Schema::create('fields_mutations', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('user_role');
            $table->string('model_name');
            $table->integer('model_obj_id');
            $table->string('field_name');
            $table->text('prev_value')->nullable();
            $table->text('current_value')->nullable();
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
        Schema::dropIfExists('fields_mutations');
    }
};
