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
        Schema::create('candidates', function (Blueprint $table) {
            $table->id();

            $table->string('firstName')->nullable();
            $table->string('lastName')->nullable();
            $table->timestamp('dateOfBirth')->nullable();
            $table->string('phone')->nullable();
            $table->string('viber')->nullable();
            $table->string('phone_parent')->nullable();
            $table->integer('nationality_id')->nullable();
            $table->integer('country_id')->nullable();
            $table->timestamp('date_arrive')->nullable();
            $table->integer('type_doc_id')->nullable();
            $table->integer('transport_id')->nullable();
            $table->text('comment')->nullable();
            $table->string('inn')->nullable();

            $table->timestamp('logist_date_arrive')->nullable();
            $table->integer('logist_place_arrive_id')->nullable();

            $table->integer('real_vacancy_id')->nullable();
            $table->integer('real_status_work_id')->nullable();
            $table->integer('active')->nullable();
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
        Schema::dropIfExists('candidates');
    }
};