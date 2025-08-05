<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
/**
* Run the migrations.
*/
public function up(): void
{
Schema::create('statistics', function (Blueprint $table) {
$table->bigIncrements('id');
$table->string('type', 191);
$table->integer('count');
$table->string('icon', 126)->nullable();
$table->string('icon_color', 120)->nullable();
$table->timestamps(); // This will create created_at and updated_at columns
});
}

/**
* Reverse the migrations.
*/
public function down(): void
{
Schema::dropIfExists('statistics');
}
};