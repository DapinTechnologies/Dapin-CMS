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
        Schema::create('about_us_partners', function (Blueprint $table) {
            $table->id();
             $table->foreignId('about_us_id')->constrained()->onDelete('cascade'); // FK to about_us table
            $table->string('name');                 // Name of partner/client/brand
            $table->string('logo')->nullable();     // Logo image path
            $table->string('url')->nullable();      // Website or profile URL
            $table->integer('order')->default(0); 
            $table->string('description')->nullable();
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
        Schema::dropIfExists('about_us_partners');
    }
};
