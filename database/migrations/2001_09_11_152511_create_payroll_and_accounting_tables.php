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
        // First create tables that don't have foreign key dependencies
        Schema::create('payroll_components', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->enum('type', ['earning', 'deduction']);
            $table->string('category');
            $table->enum('calculation_type', ['fixed', 'percentage', 'formula']);
            $table->decimal('default_amount', 15, 2)->nullable();
            $table->decimal('percentage', 5, 2)->nullable();
            $table->decimal('minimum_amount', 15, 2)->nullable();
            $table->text('formula')->nullable();
            $table->boolean('is_taxable')->default(false);
            $table->boolean('is_statutory')->default(false);
            $table->boolean('is_system_defined')->default(false);
            $table->boolean('is_active')->default(true);
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // Create payroll_periods table first since it's referenced by multiple tables
        Schema::create('payroll_periods', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->date('start_date');
            $table->date('end_date');
            $table->enum('status', ['draft', 'active', 'closed'])->default('draft');
            $table->timestamps();
        });

        // Create suppliers table first since it's referenced by billings
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->timestamps();
        });

        // Employee Payroll Drafts Table - FIXED: Use unsignedBigInteger instead of foreignId
        Schema::create('employee_payroll_drafts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->unsignedBigInteger('payroll_period_id'); // Use unsignedBigInteger first
            $table->decimal('basic_salary', 15, 2);
            $table->json('selected_components')->nullable();
            $table->json('custom_allowances')->nullable();
            $table->json('custom_deductions')->nullable();
            $table->decimal('gross_earnings', 15, 2);
            $table->decimal('total_deductions', 15, 2);
            $table->decimal('net_pay', 15, 2);
            $table->boolean('is_locked')->default(false);
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->foreignId('updated_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
           
            $table->index(['user_id', 'payroll_period_id']);

            // Add foreign key constraint separately after table creation
            $table->foreign('payroll_period_id')
                  ->references('id')
                  ->on('payroll_periods')
                  ->onDelete('cascade');
        });

        // Payroll Runs Table
        Schema::create('payroll_runs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('payroll_period_id'); // Use unsignedBigInteger first
            $table->enum('status', ['draft', 'processing', 'completed', 'failed'])->default('draft');
            $table->dateTime('run_date');
            $table->foreignId('generated_by')->constrained('users')->onDelete('cascade');
            $table->integer('total_employees')->default(0);
            $table->integer('successful_entries')->default(0);
            $table->integer('failed_entries')->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();

            // Add foreign key constraint separately
            $table->foreign('payroll_period_id')
                  ->references('id')
                  ->on('payroll_periods')
                  ->onDelete('cascade');
        });

        // Payroll Entries Table
        Schema::create('payroll_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payroll_run_id')->constrained('payroll_runs')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->unsignedBigInteger('payroll_snapshot_id')->nullable(); // Use unsignedBigInteger first
            $table->integer('attendance_days')->default(0);
            $table->decimal('attendance_hours', 8, 2)->default(0);
            $table->integer('working_days')->default(0);
            $table->decimal('working_hours', 8, 2)->default(0);
            $table->decimal('basic_salary', 15, 2);
            $table->decimal('taxable_allowances', 15, 2)->default(0);
            $table->decimal('non_taxable_allowances', 15, 2)->default(0);
            $table->decimal('overtime_earnings', 15, 2)->default(0);
            $table->decimal('bonuses', 15, 2)->default(0);
            $table->decimal('gross_earnings', 15, 2);
            $table->decimal('taxable_earnings', 15, 2);
            $table->decimal('nssf_employee', 15, 2)->default(0);
            $table->decimal('nssf_employer', 15, 2)->default(0);
            $table->decimal('nhif', 15, 2)->default(0);
            $table->decimal('paye_gross', 15, 2)->default(0);
            $table->decimal('personal_relief', 15, 2)->default(0);
            $table->decimal('paye_net', 15, 2)->default(0);
            $table->decimal('loan_deductions', 15, 2)->default(0);
            $table->decimal('advance_deductions', 15, 2)->default(0);
            $table->decimal('other_deductions', 15, 2)->default(0);
            $table->decimal('total_deductions', 15, 2);
            $table->decimal('net_pay', 15, 2);
            $table->boolean('is_paid')->default(false);
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
           
            $table->index(['payroll_run_id', 'user_id']);
            $table->index('is_paid');

            // Add foreign key constraint separately
            $table->foreign('payroll_snapshot_id')
                  ->references('id')
                  ->on('employee_payroll_drafts')
                  ->onDelete('cascade');
        });

        // The rest of your tables remain the same...
        // Payroll Payments Table
        Schema::create('payroll_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payroll_entry_id')->constrained('payroll_entries')->onDelete('cascade');
            $table->decimal('amount', 15, 2);
            $table->string('payment_method');
            $table->string('reference')->nullable();
            $table->date('payment_date');
            $table->text('notes')->nullable();
            $table->timestamps();
           
            $table->index('payroll_entry_id');
            $table->index('payment_date');
        });

        // Receivable Invoices Table
        Schema::create('receivable_invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_no')->unique();
            $table->string('payer_type');
            $table->unsignedBigInteger('payer_id');
            $table->string('payer_name');
            $table->string('payer_email')->nullable();
            $table->string('payer_phone')->nullable();
            $table->string('title');
            $table->decimal('amount', 15, 2);
            $table->date('date');
            $table->date('due_date');
            $table->text('description')->nullable();
            $table->enum('status', ['draft', 'sent', 'paid', 'overdue', 'cancelled'])->default('draft');
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->foreignId('updated_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
           
            $table->index(['payer_type', 'payer_id']);
            $table->index('invoice_no');
            $table->index('status');
            $table->index('due_date');
        });

        // Billings Table
        Schema::create('billings', function (Blueprint $table) {
            $table->id();
            $table->string('billing_no')->unique();
            $table->foreignId('supplier_id')->constrained('suppliers')->onDelete('cascade');
            $table->string('title');
            $table->decimal('amount', 15, 2);
            $table->date('date');
            $table->date('due_date');
            $table->text('description')->nullable();
            $table->enum('status', ['draft', 'sent', 'paid', 'overdue', 'cancelled'])->default('draft');
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->foreignId('updated_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
           
            $table->index('billing_no');
            $table->index('supplier_id');
            $table->index('status');
            $table->index('due_date');
        });

        // Reconciliations Table
        Schema::create('reconciliations', function (Blueprint $table) {
            $table->id();
            $table->string('reconciliation_no')->unique();
            $table->date('reconciliation_date');
            $table->string('type');
            $table->unsignedBigInteger('transaction_id');
            $table->string('transaction_type');
            $table->decimal('amount', 15, 2);
            $table->string('currency', 3)->default('KES');
            $table->enum('status', ['pending', 'matched', 'unmatched', 'adjusted'])->default('pending');
            $table->text('notes')->nullable();
            $table->string('reference_number')->nullable();
            $table->date('value_date')->nullable();
            $table->string('bank_reference')->nullable();
            $table->decimal('bank_amount', 15, 2)->nullable();
            $table->decimal('difference', 15, 2)->default(0);
            $table->text('discrepancy_reason')->nullable();
            $table->boolean('is_auto_matched')->default(false);
            $table->foreignId('reconciled_by')->nullable()->constrained('users')->onDelete('cascade');
            $table->timestamp('reconciled_at')->nullable();
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
           
            $table->index('reconciliation_no');
            $table->index(['transaction_type', 'transaction_id']);
            $table->index('status');
            $table->index('reconciliation_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop in reverse order to handle foreign key constraints
        Schema::dropIfExists('reconciliations');
        Schema::dropIfExists('billings');
        Schema::dropIfExists('receivable_invoices');
        Schema::dropIfExists('payroll_payments');
        Schema::dropIfExists('payroll_entries');
        Schema::dropIfExists('payroll_runs');
        Schema::dropIfExists('employee_payroll_drafts');
        Schema::dropIfExists('payroll_periods');
        Schema::dropIfExists('suppliers');
        Schema::dropIfExists('payroll_components');
    }
};