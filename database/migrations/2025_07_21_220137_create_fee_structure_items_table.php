<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeeStructureItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fee_structure_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('fee_structure_id');
            $table->unsignedBigInteger('fees_category_id')->nullable();
            $table->string('fee_category_title', 255)->nullable();
            $table->string('fee_category_slug', 255)->nullable();
            $table->text('fee_category_description')->nullable();
            $table->string('fee_head', 255);
            $table->decimal('amount', 10, 2);
            $table->boolean('is_one_time')->default(false);
            $table->timestamps();

            // Add indexes
            $table->index('fee_structure_id');
            $table->index('fees_category_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fee_structure_items');
    }
}