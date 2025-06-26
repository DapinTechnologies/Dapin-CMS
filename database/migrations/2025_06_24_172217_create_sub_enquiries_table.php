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
        Schema::create('sub_enquiries', function (Blueprint $table) {
            $table->id();
             $table->string('name')->nullable();
        $table->string('phone')->nullable();
        $table->string('email');
        $table->text('message')->nullable();
        $table->enum('type', ['inquiry', 'subscription'])->default('inquiry');
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
        Schema::dropIfExists('sub_enquiries');
    }
};
