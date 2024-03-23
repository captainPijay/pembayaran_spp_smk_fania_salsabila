<?php

namespace App\Imports;

use App\Models\Siswa;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SiswaImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Siswa([
            'wali_id' => $row['wali_id'],
            'wali_status' => 'ok',
            'nama' => $row['nama'],
            'nisn' => $row['nisn'],
            'jurusan' => $row['jurusan'],
            'kelas' => $row['kelas'],
            'angkatan' => $row['angkatan'],
            'jenis_kelamin' => $row['jenis_kelamin'],
            'user_id' => 1,
            'biaya_id' => $row['biaya_id'],
        ]);
    }
}
