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
        Schema::create('invoices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('invoice_no', 191);
            $table->date('assign_date');
            $table->date('due_date');
            $table->json('fee_details');
            $table->unsignedBigInteger('student_enroll_id');
            $table->unsignedBigInteger('fee_structure_id')->nullable();
            $table->json('fee_categories')->nullable();
            $table->decimal('total_fee', 15, 2)->default(0.00);
            $table->decimal('amount_due', 15, 2)->default(0.00);
            $table->decimal('discount_amount', 15, 2)->default(0.00);
            $table->decimal('fine_amount', 15, 2)->default(0.00);
            $table->text('adjustment_notes')->nullable();
            $table->string('adjustment_type', 255)->nullable();
            $table->unsignedBigInteger('adjustment_id')->nullable();
            $table->decimal('amount_paid', 15, 2)->default(0.00);
            $table->decimal('bursary_allocated', 10, 2)->default(0.00);
            $table->text('bursary_notes')->nullable();
            $table->enum('payment_status', ['pending', 'paid', 'partial'])->default('pending');
            $table->timestamps();

            // Add indexes
            $table->index('invoice_no');
            $table->index('student_enroll_id');
            $table->index('fee_structure_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
};