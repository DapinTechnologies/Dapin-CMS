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
        Schema::create('bursary_types', function (Blueprint $table) {
            $table->increments('id'); // int(11) auto-increment primary key
            $table->string('name'); // varchar(255) not null
            $table->string('code', 50); // varchar(50) not null
            $table->text('description')->nullable(); // text nullable
            $table->decimal('initial_amount', 12, 2)->default(0.00); // decimal(12,2) default 0.00
            $table->decimal('current_balance', 12, 2)->default(0.00); // decimal(12,2) default 0.00
            $table->boolean('is_active')->default(true); // tinyint(1) default 1
            $table->timestamp('created_at')->useCurrent(); // timestamp default current_timestamp()
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate(); // timestamp with on update

            // Add indexes
            $table->index('name');
            $table->index('code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bursary_types');
    }
};