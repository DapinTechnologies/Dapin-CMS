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
        Schema::table('id_card_settings', function (Blueprint $table) {
            // Check if column exists before adding
            if (!Schema::hasColumn('id_card_settings', 'prefix')) {
                $table->string('prefix', 191)->nullable()->after('address');
            }
            
            // Add other columns with similar checks if needed
            // if (!Schema::hasColumn('id_card_settings', 'other_column')) {
            //     $table->string('other_column')->nullable();
            // }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('id_card_settings', function (Blueprint $table) {
            // Only drop the column if it exists
            if (Schema::hasColumn('id_card_settings', 'prefix')) {
                $table->dropColumn('prefix');
            }
            
            // Drop other columns if needed
            // if (Schema::hasColumn('id_card_settings', 'other_column')) {
            //     $table->dropColumn('other_column');
            // }
        });
    }
};