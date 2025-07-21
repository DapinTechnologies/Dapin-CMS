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
        Schema::create('payments', function (Blueprint $table) {
            // Primary Key
            $table->bigIncrements('id');
            
            // Foreign Keys and Relationships
            $table->unsignedBigInteger('invoice_id')->nullable()->index();
            $table->unsignedBigInteger('student_enroll_id')->nullable()->index();
            $table->unsignedInteger('discount_id')->nullable()->index();
            $table->unsignedInteger('fine_id')->nullable()->index();
            
            // Payment Details
            $table->decimal('amount', 10, 2);
            $table->decimal('excess_payment', 12, 2)->default(0.00);
            $table->enum('payment_method', ['mpesa', 'bank', 'cash', 'discount', 'fine']);
            $table->string('reference_number', 100)->nullable();
            $table->date('payment_date')->nullable();
            $table->enum('status', ['pending', 'completed', 'failed', 'partial'])->default('pending');
            
            // Reconciliation Fields
            $table->boolean('is_reconciled')->default(false);
            $table->datetime('reconciled_at')->nullable();
            $table->string('reconciled_by', 255)->nullable();
            $table->text('reconciliation_notes')->nullable();
            $table->string('transaction_id', 100)->nullable();
            $table->text('notes')->nullable();
            
            // Installment Fields
            $table->boolean('is_installment')->default(false);
            $table->integer('installment_number')->nullable();
            
            // Bursary Fields
            $table->boolean('is_bursary')->default(false);
            $table->string('bursary_type', 50)->nullable();
            $table->text('bursary_notes')->nullable();
            $table->string('bursary_allocated_by', 255)->nullable();
            $table->datetime('bursary_allocated_at')->nullable();
            
            // Confirmation Fields
            $table->string('confirmed_by', 100)->nullable();
            $table->date('confirmation_date')->nullable();
            $table->date('paid_at')->nullable();
            
            // Discount/Fine Fields
            $table->boolean('is_discount')->default(false);
            $table->boolean('is_fine')->default(false);
            
            // Timestamps
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
};