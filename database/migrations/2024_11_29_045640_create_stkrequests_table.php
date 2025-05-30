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
        Schema::create('stkrequests', function (Blueprint $table) {
            $table->id();
            $table->string('MerchantRequestID');
            $table->string('CheckoutRequestID');
            $table->string('ResultCode');
            $table->string('ResultDesc');
            $table->double('Amount');
            $table->string('AccountReference');
            $table->string('TransactionDesc');
            $table->string('status');
            $table->string('phone_number');
            $table->string('name_student');
            $table->date('Date_payment');
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
        Schema::dropIfExists('stkrequests');
    }
};
