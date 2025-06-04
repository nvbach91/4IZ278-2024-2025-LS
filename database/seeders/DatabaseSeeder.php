<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Coaches
        DB::table('z_coaches')->insert([
            ['name' => 'Petr Novák', 'email' => 'petr.novak@example.com', 'oauth_provider' => 'google', 'profile_picture' => 'https://www.pngkit.com/png/detail/126-1262807_instagram-default-profile-picture-png.png'],
            ['name' => 'Jana Dvořáková', 'email' => 'jana.dvorakova@example.com', 'oauth_provider' => 'google', 'profile_picture' => 'https://www.pngkit.com/png/detail/126-1262807_instagram-default-profile-picture-png.png'],
        ]);

        // Course Templates
        DB::table('z_course_templates')->insert([
            ['title' => 'Šablona kurzu 1', 'description' => 'Popis první šablony.', 'coach_id' => 1],
            ['title' => 'Šablona kurzu 2', 'description' => 'Popis druhé šablony.', 'coach_id' => 1],
        ]);

        // Courses
        DB::table('z_courses')->insert([
            ['template_id' => 1, 'coach_id' => 1, 'start_date' => '2025-06-01', 'end_date' => '2025-08-31', 'schedule_info' => 'Pondělí a středa 15:00–17:00'],
            ['template_id' => 2, 'coach_id' => 1, 'start_date' => '2025-07-01', 'end_date' => '2025-09-15', 'schedule_info' => 'Úterý a čtvrtek 10:00–12:00'],
            ['template_id' => 2, 'coach_id' => 2, 'start_date' => '2025-06-15', 'end_date' => '2025-09-01', 'schedule_info' => 'Pátek 13:00–16:00'],
        ]);

        // Lessons
        for ($i = 1; $i <= 3; $i++) {
            for ($j = 1; $j <= 2; $j++) {
                DB::table('z_lessons')->insert([
                    'course_id' => $i,
                    'title' => "Lekce $j kurzu $i",
                    'description' => "Obsah lekce $j kurzu $i",
                    'lesson_date' => "2025-06-0" . ($j + 1),
                    'order_number' => $j,
                ]);
            }
        }

        // Homework
        for ($i = 1; $i <= 6; $i++) {
            DB::table('z_homework')->insert([
                'id' => $i,
                'title' => "Úkol k lekci $i",
                'description' => "Instrukce k úkolu $i",
                'open_at' => '2025-06-01 10:00:00',
                'due_at' => '2025-06-07 23:59:00',
            ]);
        }

        // Students
        DB::table('z_students')->insert([
            ['name' => 'Adam Kučera', 'birth_year' => 2010, 'email' => 'adam.kucera@example.com', 'profile_picture' => 'https://www.pngkit.com/png/detail/126-1262807_instagram-default-profile-picture-png.png'],
            ['name' => 'Lucie Novotná', 'birth_year' => 2011, 'email' => 'lucie.novotna@example.com', 'profile_picture' => 'https://www.pngkit.com/png/detail/126-1262807_instagram-default-profile-picture-png.png'],
            ['name' => 'Tomáš Marek', 'birth_year' => 2009, 'email' => 'tomas.marek@example.com', 'profile_picture' => 'https://www.pngkit.com/png/detail/126-1262807_instagram-default-profile-picture-png.png'],
        ]);

        // Enrollments
        for ($i = 1; $i <= 3; $i++) {
            DB::table('z_enrollments')->insert([
                'student_id' => $i,
                'course_id' => rand(1, 3),
                'enrolled_at' => '2025-05-01 12:00:00',
            ]);
        }

        // Progress
        for ($i = 1; $i <= 6; $i++) {
            DB::table('z_progress')->insert([
                'student_id' => rand(1, 3),
                'id' => $i,
                'completed_at' => '2025-06-02 17:00:00',
            ]);
        }

        // Submissions
        for ($i = 1; $i <= 6; $i++) {
            DB::table('z_submissions')->insert([
                'homework_id' => $i,
                'student_id' => rand(1, 3),
                'text' => 'Moje řešení úkolu.',
                'file_path' => 'uploads/reseni1.pdf',
                'submitted_at' => '2025-06-05 20:00:00',
                'grade' => rand(1, 5),
            ]);
        }
    }
}
