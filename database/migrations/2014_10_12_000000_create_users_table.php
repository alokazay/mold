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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('firstName')->nullable();
            $table->string('lastName')->nullable();
            $table->string('phone')->nullable();
            $table->string('account')->nullable();
            $table->string('email')->unique();
            $table->string('password')->nullable();
            $table->integer('group_id')->nullable();
            $table->integer('activation')->nullable();
            $table->integer('fl_status')->nullable();
            $table->integer('recruter_id')->nullable();
            $table->integer('manager_id')->nullable();
            $table->integer('balance')->nullable();

            $table->string('viber')->nullable();
            $table->string('facebook')->nullable();
            $table->string('account_poland')->nullable();
            $table->string('account_paypal')->nullable();
            $table->integer('account_type')->nullable();
            $table->string('account_bank_name')->nullable();
            $table->string('account_iban')->nullable();
            $table->string('account_card')->nullable();
            $table->string('account_swift')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
