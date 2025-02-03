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
        Schema::create('advertisements', function (Blueprint $table) {
            $table->id();
            $table->string('city')->nullable();
            $table->string('beds_count')->nullable();
            $table->integer('rooms_count')->nullable();
            $table->decimal('average_rating',2,1)->nullable();
            $table->decimal('average_price_quality',2,1)->nullable();
            $table->decimal('average_timeliness_of_the_meeting',2,1)->nullable();
            $table->decimal('average_purity',2,1)->nullable();
            $table->decimal('average_photo_match',2,1)->nullable();
            $table->decimal('average_convenience_of_location',2,1)->nullable();
            $table->integer('guests_count')->nullable();
            $table->unsignedInteger('assessments_count')->default(0);
            $table->integer('price');
            $table->string('address');
            $table->string('rules_cancellation')->nullable();
            $table->text('description')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('type_id')->constrained()->onDelete('cascade');
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
        Schema::dropIfExists('advertisements');
    }
};
