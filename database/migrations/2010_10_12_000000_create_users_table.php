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
            $table->string('name');
            $table->string('surname');
            $table->string('patronymic');
            $table->string('post')->nullable();
            $table->unsignedBigInteger('tax_number')->nullable();
            $table->string('legal_entity')->nullable();
            $table->string('legal_address')->nullable();
            $table->string('address_docs')->nullable();
            $table->string('secret_code')->nullable();
            $table->unsignedBigInteger('phone_code')->nullable();
            $table->dateTime('phone_code_at')->nullable();
            $table->string('status')->nullable();
            $table->string('phone')->nullable();
            $table->dateTime('secret_code_at')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
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
