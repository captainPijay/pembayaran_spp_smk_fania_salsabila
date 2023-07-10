<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Siswa;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\WaliBank;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Siswa::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        User::create([
            'name' => 'Muhammad Zahran',
            'akses' => 'operator',
            'nohp' => '082180864290',
            'nohp_verified_at' => now(),
            'email' => 'muhammadzahran02@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('1')
        ]);
        // User::create([
        //     'name' => 'Operator 2',
        //     'akses' => 'operator',
        //     'nohp' => '081994743200',
        //     'nohp_verified_at' => now(),
        //     'email' => 'operator2@gmail.com',
        //     'email_verified_at' => now(),
        //     'password' => bcrypt('1')
        // ]);
        // User::create([
        //     'name' => 'Kevin',
        //     'akses' => 'wali',
        //     'nohp' => '082180864290',
        //     'nohp_verified_at' => now(),
        //     'email' => 'kevin@gmail.com',
        //     'email_verified_at' => now(),
        //     'password' => bcrypt('1')
        // ]);
        // WaliBank::create([
        //     'wali_id' => 2,
        //     'kode' => '000',
        //     'nama_bank' => 'BNI Syariah',
        //     'nama_rekening' => 'Kevin',
        //     'nomor_rekening' => '7870598631',
        // ]);
    }
}
