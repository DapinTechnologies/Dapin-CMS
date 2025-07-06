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
        Schema::create('about_us_accreditations', function (Blueprint $table) {
            $table->id();
              $table->foreignId('about_us_id')->constrained()->onDelete('cascade'); // assumes about_us table exists
        $table->string('name');
        $table->string('logo')->nullable(); // store image path/logo file
        $table->text('description')->nullable();
        $table->integer('order')->default(0); // for displa
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
        Schema::dropIfExists('about_us_accreditations');
    }
};
