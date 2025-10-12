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
        Schema::table('payroll_periods', function (Blueprint $table) {
            // Add period_id column if it doesn't exist
            if (!Schema::hasColumn('payroll_periods', 'period_id')) {
                $table->string('period_id')->nullable()->after('name');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payroll_periods', function (Blueprint $table) {
            // Remove the period_id column if it exists
            if (Schema::hasColumn('payroll_periods', 'period_id')) {
                $table->dropColumn('period_id');
            }
        });
    }
};