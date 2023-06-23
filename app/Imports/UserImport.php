<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;

class UserImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new User([
            'name' => $row[0],
            'akses' => $row[1],
            'nohp' => $row[2],
            'nohp_verified_at' => now(),
            'email' => $row[3],
            'password' => bcrypt($row[4])
        ]);
    }
}
