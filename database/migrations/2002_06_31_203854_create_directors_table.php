<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
/**
* Run the migrations.
*/
public function up(): void
{
Schema::create('directors', function (Blueprint $table) {
$table->id(); // Equivalent to int NOT NULL AUTO_INCREMENT
$table->string('name', 209); // varchar(209) NOT NULL
$table->string('title', 100); // varchar(100) NOT NULL
$table->text('message'); // text NOT NULL
$table->text('image')->nullable(); // text DEFAULT NULL
$table->timestamps(6); // timestamp(6) for created_at and updated_at
});

// Set the engine to MyISAM
DB::statement('ALTER TABLE directors ENGINE = MyISAM');

// Set auto_increment starting value
DB::statement('ALTER TABLE directors AUTO_INCREMENT = 2');
}

/**
* Reverse the migrations.
*/
public function down(): void
{
Schema::dropIfExists('directors');
}
};