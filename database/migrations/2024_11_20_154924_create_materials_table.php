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
        Schema::create('materials', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('type'); // PDF, video, etc.
            $table->string('file_path'); // Path to uploaded file
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('author')->nullable();
            $table->string('publisher')->nullable();
            $table->string('language')->default('English');
            $table->string('edition')->nullable();
            $table->string('isbn')->nullable();
            $table->boolean('is_public')->default(false); // Public or private
            $table->text('description')->nullable();
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
        Schema::dropIfExists('materials');
    }
};
