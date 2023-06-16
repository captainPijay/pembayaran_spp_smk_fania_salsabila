<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Auth;
use Illuminate\Http\Request;

class WaliMuridSiswaController extends Controller
{
    public function index()
    {
        $data['models'] = Auth::user()->siswa;
        return view('wali.siswa_index', $data);
    }
    public function show(Siswa $siswa)
    {
        return view('wali.siswa_show_wali', [
            'model' => $siswa->with('statuses')->siswaPrevent(),
            'title' => 'Detail Siswa'
        ]);
    }
}
