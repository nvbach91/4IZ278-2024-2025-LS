<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Ensure lesson_id column exists
        Schema::table('z_progress', function (Blueprint $table) {
            if (!Schema::hasColumn('z_progress', 'lesson_id')) {
                $table->unsignedBigInteger('lesson_id')->after('student_id');
            }
        });

        // Drop existing FK if present
        $fkName = DB::table('information_schema.KEY_COLUMN_USAGE')
            ->where('TABLE_SCHEMA', DB::getDatabaseName())
            ->where('TABLE_NAME', 'z_progress')
            ->where('COLUMN_NAME', 'lesson_id')
            ->whereNotNull('REFERENCED_TABLE_NAME')
            ->value('CONSTRAINT_NAME');

        if ($fkName) {
            DB::statement("ALTER TABLE z_progress DROP FOREIGN KEY `$fkName`");
        }

        // Create FK with cascade
        Schema::table('z_progress', function (Blueprint $table) {
            $table->foreign('lesson_id')
                ->references('id')
                ->on('z_lessons')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        $fkName = DB::table('information_schema.KEY_COLUMN_USAGE')
            ->where('TABLE_SCHEMA', DB::getDatabaseName())
            ->where('TABLE_NAME', 'z_progress')
            ->where('COLUMN_NAME', 'lesson_id')
            ->whereNotNull('REFERENCED_TABLE_NAME')
            ->value('CONSTRAINT_NAME');

        if ($fkName) {
            DB::statement("ALTER TABLE z_progress DROP FOREIGN KEY `$fkName`");
        }

        if (Schema::hasColumn('z_progress', 'lesson_id')) {
            Schema::table('z_progress', function (Blueprint $table) {
                $table->dropColumn('lesson_id');
            });
        }
    }
};
