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
        Schema::table('users', function (Blueprint $table) {
            // Check current column positions and add missing ones
            $columns = [
                'kra_pin' => ['after' => 'tin_no', 'type' => 'string'],
                'nssf_number' => ['after' => 'kra_pin', 'type' => 'string'],
                'sha_number' => ['after' => 'nssf_number', 'type' => 'string'],
                'nhif' => ['after' => 'sha_number', 'type' => 'string'],
            ];

            foreach ($columns as $columnName => $config) {
                if (!Schema::hasColumn('users', $columnName)) {
                    if ($config['type'] === 'string') {
                        $table->string($columnName)->nullable()->after($config['after']);
                    }
                }
            }

            // Add indexes
            $table->index(['nssf_number', 'nhif', 'kra_pin']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $columnsToDrop = ['kra_pin', 'nssf_number', 'sha_number', 'nhif'];
            
            foreach ($columnsToDrop as $column) {
                if (Schema::hasColumn('users', $column)) {
                    $table->dropColumn($column);
                }
            }

            // Drop composite index
            $table->dropIndex(['nssf_number', 'nhif', 'kra_pin']);
        });
    }
};