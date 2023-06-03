<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Siswa;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\WaliBank;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        User::create([
            'name' => 'Muhammad Zahran',
            'akses' => 'operator',
            'nohp' => '085956344454',
            'nohp_verified_at' => now(),
            'email' => 'muhammadzahran11@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('1')
        ]);
        User::create([
            'name' => 'Operator 2',
            'akses' => 'operator',
            'nohp' => '081994743200',
            'nohp_verified_at' => now(),
            'email' => 'operator2@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('1')
        ]);
        User::create([
            'name' => 'Kevin',
            'akses' => 'wali',
            'nohp' => '082180864290',
            'nohp_verified_at' => now(),
            'email' => 'kevin@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('1')
        ]);
        WaliBank::create([
            'wali_id' => 2,
            'kode' => '000',
            'nama_bank' => 'BNI Syariah',
            'nama_rekening' => 'Kevin',
            'nomor_rekening' => '7870598631',
        ]);
        Siswa::create([
            'nama' => 'Mancek',
            'nisn' => '80228382',
            'wali_status' => 'ok',
            'foto' => null,
            'jurusan' => 'Asisten Keperawatan',
            'jenis_kelamin' => 'Laki-Laki',
            'kelas' => 10,
            'angkatan' => 2022,
            'user_id' => 1,
            'wali_id' => 2,
        ]);
    }
}
