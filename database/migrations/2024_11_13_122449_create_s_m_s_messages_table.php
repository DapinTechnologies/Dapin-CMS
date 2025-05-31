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
        Schema::create('s_m_s_messages', function (Blueprint $table) {
            $table->id();
            $table->string('phone_number'); // Recipient phone number
            $table->text('message'); // Message content
            $table->boolean('is_bulk')->default(false); // Bulk message indicator
            $table->string('status')->default('pending'); // Status of the message
            $table->timestamp('sent_at')->nullable(); // Timestamp for sent messages
            $table->foreignId('api_configuration_id')->constrained(); // Link to 
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
        Schema::dropIfExists('s_m_s_messages');
    }
};
