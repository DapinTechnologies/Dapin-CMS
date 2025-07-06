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
        Schema::create('about_us_histories', function (Blueprint $table) {
            $table->id();
             $table->foreignId('about_us_id')->constrained()->onDelete('cascade');
        $table->year('year')->nullable();
        $table->string('title');
        $table->text('description')->nullable();
        $table->string('image')->nullable(); // Path to image
        $table->integer('order')->default(0); // For ordering timeline items
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
        Schema::dropIfExists('about_us_histories');
    }
};
