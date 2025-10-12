<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('expenses', function (Blueprint $table) {
            // Add billing_id column if it doesn't exist
            if (!Schema::hasColumn('expenses', 'billing_id')) {
                $table->foreignId('billing_id')
                      ->nullable()
                      ->after('invoice_id')
                      ->constrained('billings')
                      ->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('expenses', function (Blueprint $table) {
            // Remove the billing_id column if it exists
            if (Schema::hasColumn('expenses', 'billing_id')) {
                $table->dropForeign(['billing_id']);
                $table->dropColumn('billing_id');
            }
        });
    }
};