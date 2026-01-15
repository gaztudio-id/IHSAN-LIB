<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Member;
use App\Models\Book;
use App\Models\SbpRequest;
use App\Models\User;

class DummyDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 0. Buat Data Users (Admin & Staff)
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@ihsan.lib',
            'password' => bcrypt('password'),
            'role' => 'super_admin'
        ]);

        User::create([
            'name' => 'Staff Perpustakaan',
            'email' => 'staff@ihsan.lib',
            'password' => bcrypt('password'),
            'role' => 'staff_perpus'
        ]);
        
        // Data Dummy Lainnya dinonaktifkan untuk produksi
        /*
        Member::create([...]);
        Book::create([...]);
        ...
        */
    }
}
