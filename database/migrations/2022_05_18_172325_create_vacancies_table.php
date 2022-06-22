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
        Schema::create('vacancies', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->integer('activation')->nullable();
            $table->integer('user_id')->nullable();
            $table->timestamp('deadline_from')->nullable();
            $table->timestamp('deadline_to')->nullable();
            $table->integer('count_men')->nullable();
            $table->integer('count_women')->nullable();
            $table->integer('count_people')->nullable();
            $table->integer('salary')->nullable();
            $table->string('salary_description')->nullable();
            $table->float('count_hours')->nullable();
            $table->integer('doc_id')->nullable();
            $table->integer('housing_cost')->nullable();
            $table->string('housing_people')->nullable();
            $table->string('housing_description')->nullable();
            $table->integer('recruting_cost')->nullable();
            $table->integer('cost_pay_lead')->nullable();
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
        Schema::dropIfExists('vacancies');
    }
};
