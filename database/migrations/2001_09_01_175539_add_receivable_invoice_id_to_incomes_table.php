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
        Schema::table('incomes', function (Blueprint $table) {
            // Add receivable_invoice_id column if it doesn't exist
            if (!Schema::hasColumn('incomes', 'receivable_invoice_id')) {
                $table->foreignId('receivable_invoice_id')
                      ->nullable()
                      ->after('invoice_id')
                      ->constrained('receivable_invoices')
                      ->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('incomes', function (Blueprint $table) {
            // Remove the receivable_invoice_id column if it exists
            if (Schema::hasColumn('incomes', 'receivable_invoice_id')) {
                $table->dropForeign(['receivable_invoice_id']);
                $table->dropColumn('receivable_invoice_id');
            }
        });
    }
};