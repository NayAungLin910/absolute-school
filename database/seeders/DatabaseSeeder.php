<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Batch;
use App\Models\Moderator;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // only one admin acccount
        Admin::create([
            "name" => "admin",
            "email" => "admin@gmail.com",
            "password" => Hash::make('admin123'),
        ]);

        // 3 accounts each for moderator, teacher and student accounts
        for ($i = 1; $i <= 3; $i++) {
            $student = User::create([
                "name" => "stu" . $i,
                "email" => "stu" . $i . "@gmail.com",
                "image" => "student_profile_" . $i . ".jpg",
                "password" => Hash::make("stu" . $i),
                "approve" => "yes",
            ]);
            $student->batch()->sync([1]);

            Teacher::create([
                "name" => "teach" . $i,
                "email" => "teach" . $i . "@gmail.com",
                "image" => "teacher_profile_" . $i . ".jpg",
                "password" => Hash::make("teach" . $i),
                "approve" => "yes",
            ]);

            Moderator::create([
                "name" => "mod" . $i,
                "email" => "mod" . $i . "@gmail.com",
                "password" => Hash::make("mod" . $i),
                "approve" => "yes",
            ]);
        }

        // create 5 batches
        for ($i = 1; $i <= 5; $i++) {
            Batch::create([
                "name" => "HND - " . $i,
            ]);
        }

        // create 3 subjects
        for ($i = 1; $i <= 3; $i++) {
            Subject::create([
                "name" => "Subject - " . $i . " (HND - " . $i . ")",
                "teacher_id" => 1,
                "batch_id" => $i,
                "admin_id" => 1,
                "meeting_id" => "12341234" . $i,
                "meeting_password" => "123412341234" . $i,
                "meeting_link" => "https://dummyzoomlink.com",
            ]);
        }
    }
}
