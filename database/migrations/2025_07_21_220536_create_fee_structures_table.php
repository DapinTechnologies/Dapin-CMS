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
        Schema::create('fee_structures', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('faculty_id');
            $table->unsignedInteger('program_id');
            $table->string('semester');
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            // Add indexes
            $table->index('faculty_id');
            $table->index('program_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fee_structures');
    }
};