<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Tagihan;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\Return_;

class KartuSppController extends Controller
{
    public function index(Request $request)
    {
        $tagihan = Tagihan::where('siswa_id', $request->siswa_id)->get();
        $siswa = Siswa::firstWhere('id', $request->siswa_id);
        return view('operator.kartuspp_index', [
            'tagihan' => $tagihan,
            'siswa' => $siswa
        ]);
    }
}
