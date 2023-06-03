<?php

namespace App\Http\Controllers;

use App\Models\BankSekolah;
use App\Models\Tagihan;
use Auth;
use Illuminate\Http\Request;

class WaliMuridTagihanController extends Controller
{
    public function index()
    {
        // $siswaId = Auth::user()->getAllSiswaId(); getAllSiswaId dapat dari model user
        $data['tagihan'] = Tagihan::WaliSiswa()->get(); //karna extends model tagihan maka ada method scopewalisiswa
        return view('wali.tagihan_index', $data);
    }
    public function show($id)
    {
        // $siswaId = Auth::user()->getAllSiswaId();
        // $siswaId = Auth::user()->siswa->pluck('id'); Sama Aja
        $tagihan = Tagihan::WaliSiswa()->findOrfail($id);
        $banksekolah = BankSekolah::all();
        $data['bankSekolah'] = $banksekolah;
        $data['tagihan'] = $tagihan;
        $data['siswa'] = $tagihan->siswa;
        return view('wali.tagihan_show', $data);
    }
}
