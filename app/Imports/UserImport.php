<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UserImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new User([
            'name' => $row['name'],
            'akses' => 'operator',
            'nohp' => $row['nohp'],
            'nohp_verified_at' => now(),
            'email' => $row['email'],
            'email_verified_at' => now(),
            'password' => bcrypt(12345678)
        ]);
    }
}
