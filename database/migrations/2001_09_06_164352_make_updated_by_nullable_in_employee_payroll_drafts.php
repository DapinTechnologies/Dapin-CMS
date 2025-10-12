<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('employee_payroll_drafts', function (Blueprint $table) {
            // Drop the existing foreign key constraint
            $table->dropForeign(['updated_by']);
            
            // Make the column nullable
            $table->unsignedBigInteger('updated_by')->nullable()->change();
            
            // Re-add the foreign key constraint with nullable
            $table->foreign('updated_by')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('employee_payroll_drafts', function (Blueprint $table) {
            $table->dropForeign(['updated_by']);
            $table->unsignedBigInteger('updated_by')->nullable(false)->change();
            $table->foreign('updated_by')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }
};