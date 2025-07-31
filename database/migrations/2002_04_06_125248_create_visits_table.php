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
Schema::create('visits', function (Blueprint $table) {
$table->id();
$table->string('device_type', 191); // varchar(191)
$table->string('ip_address', 191); // varchar(191)
$table->decimal('latitude', 10, 7)->nullable(); // decimal(10,7) DEFAULT NULL
$table->decimal('longitude', 10, 7)->nullable(); // decimal(10,7) DEFAULT NULL
$table->string('page_visited', 191); // varchar(191)
$table->string('country', 199)->nullable(); // varchar(199) DEFAULT NULL
$table->string('city', 199)->nullable();
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
Schema::dropIfExists('visits');
}
};