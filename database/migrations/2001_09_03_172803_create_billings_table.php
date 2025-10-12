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
        // First, drop the table if it exists to avoid conflicts
        Schema::dropIfExists('billings');
        
        Schema::create('billings', function (Blueprint $table) {
            $table->id();
            $table->string('billing_no', 100)->unique();
            $table->unsignedBigInteger('supplier_id');
            $table->string('title');
            $table->decimal('amount', 15, 2)->default(0.00);
            $table->date('date');
            $table->date('due_date')->nullable();
            $table->text('description')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            // Add indexes
            $table->index('billing_no');
            $table->index('supplier_id');
            $table->index('created_by');
            $table->index('updated_by');
            $table->index('date');
            $table->index('due_date');
            $table->index('status');
        });

        // Add foreign key constraints separately
        Schema::table('billings', function (Blueprint $table) {
            // Only add supplier foreign key if suppliers table exists
            if (Schema::hasTable('suppliers')) {
                $table->foreign('supplier_id')
                      ->references('id')
                      ->on('suppliers')
                      ->onDelete('cascade');
            }
            
            // Only add user foreign keys if users table exists
            if (Schema::hasTable('users')) {
                $table->foreign('created_by')
                      ->references('id')
                      ->on('users')
                      ->onDelete('set null');
                      
                $table->foreign('updated_by')
                      ->references('id')
                      ->on('users')
                      ->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('billings');
    }
};