<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $fkName = DB::table('information_schema.KEY_COLUMN_USAGE')
            ->where('TABLE_SCHEMA', DB::getDatabaseName())
            ->where('TABLE_NAME', 'z_submissions')
            ->where('COLUMN_NAME', 'homework_id')
            ->whereNotNull('REFERENCED_TABLE_NAME')
            ->value('CONSTRAINT_NAME');

        if ($fkName) {
            DB::statement("ALTER TABLE z_submissions DROP FOREIGN KEY `$fkName`");
        }

        Schema::table('z_submissions', function (Blueprint $table) {
            $table->foreign('homework_id')
                ->references('id')
                ->on('z_homework')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        $fkName = DB::table('information_schema.KEY_COLUMN_USAGE')
            ->where('TABLE_SCHEMA', DB::getDatabaseName())
            ->where('TABLE_NAME', 'z_submissions')
            ->where('COLUMN_NAME', 'homework_id')
            ->whereNotNull('REFERENCED_TABLE_NAME')
            ->value('CONSTRAINT_NAME');

        if ($fkName) {
            DB::statement("ALTER TABLE z_submissions DROP FOREIGN KEY `$fkName`");
        }
    }
};
