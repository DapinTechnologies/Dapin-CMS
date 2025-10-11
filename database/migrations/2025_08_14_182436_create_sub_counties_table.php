<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up()
{
Schema::create('sub_counties', function (Blueprint $table) {
$table->integer('SubCountyID')->primary(); // Primary key
$table->string('SubCountyName', 255);
$table->integer('CountyID')->nullable();
});
}

public function down()
{
Schema::dropIfExists('sub_counties');
}
};