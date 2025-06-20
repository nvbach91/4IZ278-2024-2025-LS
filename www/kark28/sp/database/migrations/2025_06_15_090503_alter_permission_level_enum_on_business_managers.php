<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("
            ALTER TABLE `business_managers`
            MODIFY COLUMN `permission_level`
            ENUM('owner','manager','worker') NOT NULL
            DEFAULT 'worker'
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("
            ALTER TABLE `business_managers`
            MODIFY COLUMN `permission_level`
            VARCHAR(255) NOT NULL
        ");
    }
};
