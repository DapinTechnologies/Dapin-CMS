<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDirectorsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('directors', function (Blueprint $table) {
            $table->id(); // id INT AUTO_INCREMENT PRIMARY KEY
            $table->string('name', 209); // name VARCHAR(209) NOT NULL
            $table->string('title', 100); // title VARCHAR(100) NOT NULL
            $table->text('message'); // message TEXT NOT NULL
            $table->text('image')->nullable(); // image TEXT NULL
            $table->timestamps(6); // created_at and updated_at with precision(6)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('directors');
    }
}
