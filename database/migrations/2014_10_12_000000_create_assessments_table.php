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
        Schema::create('assessments', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('price_quality');
            $table->unsignedTinyInteger('timeliness_of_the_meeting');
            $table->unsignedTinyInteger('purity');
            $table->unsignedTinyInteger('photo_match');
            $table->unsignedTinyInteger('convenience_of_location');
            $table->decimal('average_rating',2,1);
            $table->string('review')->nullable();
            $table->string('status');
            $table->boolean('is_anonymous')->default(false);
            $table->foreignId('advertisement_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
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
        Schema::dropIfExists('assessments');
    }
};
