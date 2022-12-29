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
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->string('phone')->unique();
            $table->string('terms_conditions')->default('rejected');
            $table->string('first_names')->nullable();
            $table->string('last_name')->nullable();
            $table->string('dob')->nullable();
            $table->string('email')->nullable();
            $table->string('start_date')->nullable();
            $table->string('company')->nullable();
            $table->string('end_date')->nullable();
            $table->string('salary')->nullable();
            $table->string('occupation')->nullable();
            $table->string('payment')->default('pending');
            $table->string('status')->default('incomplete');
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
        Schema::dropIfExists('registrations');
    }
};
