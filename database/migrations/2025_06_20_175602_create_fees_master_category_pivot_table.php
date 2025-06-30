<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeesMasterCategoryPivotTable extends Migration
{
    public function up()
{
    Schema::create('fees_master_category', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('fees_master_id');
        $table->unsignedBigInteger('fees_category_id');
        $table->timestamps();

        // First create the columns, then add constraints
        $table->index('fees_master_id');
        $table->index('fees_category_id');
    });

    // Add foreign key constraints separately
    Schema::table('fees_master_category', function (Blueprint $table) {
        $table->foreign('fees_master_id')
              ->references('id')
              ->on('fees_masters')
              ->onDelete('cascade');
              
        $table->foreign('fees_category_id')
              ->references('id')
              ->on('fees_categories')
              ->onDelete('cascade');
    });
}
}
