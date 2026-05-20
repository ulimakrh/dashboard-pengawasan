<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Akun Super Admin
        User::updateOrCreate(
            ['email' => 'superadmin@kemenlu.go.id'],
            [
                'name' => 'Super Admin',
                'password' => bcrypt('password'),
                'role' => 'super_admin'
            ]
        );

        // 2. Akun Manager
        User::updateOrCreate(
            ['email' => 'manager@kemenlu.go.id'],
            [
                'name' => 'Manager Itwil III',
                'password' => bcrypt('password'),
                'role' => 'manager'
            ]
        );

        // 3. Akun Itwil I
        User::updateOrCreate(
            ['email' => 'itwil1@kemenlu.go.id'],
            [
                'name' => 'Auditor Itwil I',
                'password' => bcrypt('password'),
                'role' => 'itwil',
                'wilayah_id' => 'Itwil I'
            ]
        );

        // 4. Akun Itwil II
        User::updateOrCreate(
            ['email' => 'itwil2@kemenlu.go.id'],
            [
                'name' => 'Auditor Itwil II',
                'password' => bcrypt('password'),
                'role' => 'itwil',
                'wilayah_id' => 'Itwil II'
            ]
        );

        // 5. Akun Itwil III
        User::updateOrCreate(
            ['email' => 'itwil3@kemenlu.go.id'],
            [
                'name' => 'Auditor Itwil III',
                'password' => bcrypt('password'),
                'role' => 'itwil',
                'wilayah_id' => 'Itwil III'
            ]
        );

        // 6. Akun Itwil IV
        User::updateOrCreate(
            ['email' => 'itwil4@kemenlu.go.id'],
            [
                'name' => 'Auditor Itwil IV',
                'password' => bcrypt('password'),
                'role' => 'itwil',
                'wilayah_id' => 'Itwil IV'
            ]
        );

        // 7. Akun Satker
        User::updateOrCreate(
            ['email' => 'satker@kemenlu.go.id'],
            [
                'name' => 'Admin KJRI',
                'password' => bcrypt('password'),
                'role' => 'satker',
                'satker_id' => 1
            ]
        );
    }
}
