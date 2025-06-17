<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1) Přidáme dočasný TIMESTAMP sloupec s nullable, aby se data nepřerušila
        DB::statement("
            ALTER TABLE `reservations`
            ADD COLUMN `temp_created_at` TIMESTAMP NULL
            AFTER `status`
        ");

        // 2) Zkopírujeme existující hodnoty (nebo NOW tam, kde je NULL)
        DB::statement("
            UPDATE `reservations`
            SET `temp_created_at` = COALESCE(`created_at`, CURRENT_TIMESTAMP)
        ");

        // 3) Odstraníme původní DATETIME sloupec
        DB::statement("
            ALTER TABLE `reservations`
            DROP COLUMN `created_at`
        ");

        // 4) Přejmenujeme temp_created_at na created_at a nastavíme NOT NULL DEFAULT CURRENT_TIMESTAMP
        DB::statement("
            ALTER TABLE `reservations`
            CHANGE COLUMN `temp_created_at` `created_at`
            TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
        ");
    }

    public function down(): void
    {
        // Rollback: vrátíme DATETIME bez defaultu

        // 1) Přidáme zpět dočasný DATETIME nullable
        DB::statement("
            ALTER TABLE `reservations`
            ADD COLUMN `old_created_at` DATETIME NULL
            AFTER `status`
        ");

        // 2) Zkopírujeme data ze sloupce TIMESTAMP
        DB::statement("
            UPDATE `reservations`
            SET `old_created_at` = `created_at`
        ");

        // 3) Odstraníme TIMESTAMP sloupec
        DB::statement("
            ALTER TABLE `reservations`
            DROP COLUMN `created_at`
        ");

        // 4) Přejmenujeme old_created_at zpět na created_at DATETIME
        DB::statement("
            ALTER TABLE `reservations`
            CHANGE COLUMN `old_created_at` `created_at`
            DATETIME NULL
        ");
    }
};
