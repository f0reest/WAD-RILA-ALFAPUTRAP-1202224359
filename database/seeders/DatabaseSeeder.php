<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use RuntimeException;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $email = (string) config('admin.email');
        $password = (string) config('admin.password');

        if ($email === '' || $password === '') {
            throw new RuntimeException('Set ADMIN_EMAIL and ADMIN_PASSWORD before running the database seeder.');
        }

        User::updateOrCreate(
            ['email' => $email],
            [
                'name' => (string) config('admin.name'),
                'password' => Hash::make($password),
            ]
        );
    }
}
