<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeeCategoryPivotTable extends Migration
{
    public function up()
    {
        Schema::create('fee_category', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fee_id');
            $table->unsignedBigInteger('fees_category_id');
            $table->timestamps();

            $table->foreign('fee_id')
                  ->references('id')
                  ->on('fees')
                  ->onDelete('cascade');
                  
            $table->foreign('fees_category_id')
                  ->references('id')
                  ->on('fees_categories')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('fee_category');
    }
}