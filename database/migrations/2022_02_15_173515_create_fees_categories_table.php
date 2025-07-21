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
        Schema::create('fees_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title', 191);
            $table->string('slug', 191);
            $table->text('description')->nullable();
            $table->boolean('status')->default(true);
            $table->double('amount')->default(0);
            $table->enum('fee_type', ['government', 'external', 'both'])->nullable();
            $table->timestamps();

            // Add indexes
            $table->index('title');
            $table->index('slug');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fees_categories');
    }
};