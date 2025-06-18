<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('student_enroll_id')->nullable()->constrained()->onDelete('set null');
            $table->decimal('amount', 10, 2);
            $table->enum('payment_method', ['mpesa', 'bank', 'cash']);
            $table->string('reference_number', 100)->nullable();
            $table->date('payment_date')->nullable();
            $table->enum('status', ['pending', 'completed', 'failed', 'partial'])->default('pending');
            $table->string('transaction_id', 100)->nullable();
            $table->text('notes')->nullable();
            $table->boolean('is_installment')->default(false);
            $table->integer('installment_number')->nullable();
            $table->string('confirmed_by', 100)->nullable();
            $table->date('confirmation_date')->nullable();
            $table->date('paid_at')->nullable();
            $table->timestamps();
            
            // Indexes
            $table->index('invoice_id');
            $table->index('student_enroll_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('payments');
    }
}