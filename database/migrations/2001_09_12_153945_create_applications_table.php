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
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            
            // Registration and basic info
            $table->string('registration_no')->unique();
            $table->unsignedBigInteger('batch_id')->nullable();
            $table->unsignedBigInteger('program_id')->nullable();
            $table->date('apply_date')->nullable();
            
            // Personal information
            $table->string('first_name');
            $table->string('last_name');
            $table->string('father_name')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('father_occupation')->nullable();
            $table->string('mother_occupation')->nullable();
            $table->text('father_photo')->nullable();
            $table->text('mother_photo')->nullable();
            
            // Address information
            $table->string('country')->nullable();
            $table->unsignedBigInteger('present_province')->nullable();
            $table->unsignedBigInteger('present_district')->nullable();
            $table->text('present_village')->nullable();
            $table->text('present_address')->nullable();
            $table->unsignedBigInteger('permanent_province')->nullable();
            $table->unsignedBigInteger('permanent_district')->nullable();
            $table->text('permanent_village')->nullable();
            $table->text('permanent_address')->nullable();
            
            // Contact and demographic info
            $table->tinyInteger('gender')->comment('1 Male, 2 Female & 3 Other');
            $table->date('dob');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('emergency_phone')->nullable();
            $table->string('religion')->nullable();
            $table->string('caste')->nullable();
            $table->string('mother_tongue')->nullable();
            $table->tinyInteger('marital_status')->nullable();
            $table->tinyInteger('blood_group')->nullable();
            $table->string('nationality')->nullable();
            $table->string('national_id')->nullable();
            $table->string('passport_no')->nullable();
            
            // Educational background - School
            $table->text('school_name')->nullable();
            $table->string('school_exam_id')->nullable();
            $table->string('school_graduation_field')->nullable();
            $table->string('school_graduation_year')->nullable();
            $table->string('school_graduation_point')->nullable();
            $table->string('school_transcript')->nullable();
            $table->string('school_certificate')->nullable();
            
            // Educational background - College
            $table->text('collage_name')->nullable();
            $table->string('collage_exam_id')->nullable();
            $table->string('collage_graduation_field')->nullable();
            $table->string('collage_graduation_year')->nullable();
            $table->string('collage_graduation_point')->nullable();
            $table->string('collage_transcript')->nullable();
            $table->string('collage_certificate')->nullable();
            
            // Files and media
            $table->text('photo')->nullable();
            $table->text('signature')->nullable();
            
            // Payment information
            $table->double('fee_amount', 10, 2)->nullable();
            $table->tinyInteger('pay_status')->default(0)->comment('0 Unpaid, 1 Paid, 2 Cancel');
            $table->integer('payment_method')->nullable();
            
            // Status
            $table->tinyInteger('status')->default(1)->comment('0 Rejected, 1 Pending, 2 Approve');
            
            // KCSE specific fields
            $table->string('kcse_certificate')->nullable();
            $table->string('kcse_result_slip')->nullable();
            $table->string('kcse_index_no')->nullable();
            $table->string('kcse_year')->nullable();
            $table->integer('county_id')->nullable();
            $table->integer('sub_county_id')->nullable();
            $table->string('mode_of_study')->nullable();
            $table->string('kcse_grade')->nullable();
            
            // Audit fields
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            
            $table->timestamps();

            // Indexes
            $table->index('registration_no');
            $table->index('email');
            $table->index('batch_id');
            $table->index('program_id');
            $table->index('status');
            $table->index('pay_status');
            
            // Foreign key constraints (add these if the referenced tables exist)
            // $table->foreign('batch_id')->references('id')->on('batches')->onDelete('set null');
            // $table->foreign('program_id')->references('id')->on('programs')->onDelete('set null');
            // $table->foreign('present_province')->references('id')->on('provinces')->onDelete('set null');
            // $table->foreign('present_district')->references('id')->on('districts')->onDelete('set null');
            // $table->foreign('permanent_province')->references('id')->on('provinces')->onDelete('set null');
            // $table->foreign('permanent_district')->references('id')->on('districts')->onDelete('set null');
            // $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            // $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};