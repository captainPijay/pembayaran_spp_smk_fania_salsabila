<?php

namespace App\Http\Controllers;

use App\Models\Tagihan;
use Illuminate\Http\Request;

class LaporanTagihanController extends Controller
{
    public function index(Request $request)
    {
        $tagihan = Tagihan::latest();
        $title = '';
        if ($request->filled('bulan')) {
            $tagihan = $tagihan->whereMonth('tanggal_tagihan', $request->bulan);
            $title = ' Bulan ' . ubahNamaBulan($request->bulan);
        }
        if ($request->filled('tahun')) {
            $tagihan = $tagihan->whereYear('tanggal_tagihan', $request->tahun);
            $title = $title . ' Tahun ' . $request->tahun;
        }
        if ($request->filled('status')) {
            $tagihan = $tagihan->where('status', $request->status);
            $title = $title . ' Status Tagihan ' . $request->status;
        }
        if ($request->filled('kelas')) {
            $tagihan = $tagihan->whereHas('siswa', function ($q) use ($request) {
                $q->where('kelas', $request->kelas);
            });
            $title = $title . ' Jurusan ' . $request->jurusan;
        }
        if ($request->filled('angkatan')) {
            $tagihan = $tagihan->whereHas('siswa', function ($q) use ($request) {
                $q->where('angkatan', $request->angkatan);
            });
            $title = $title . ' Angkatan ' . $request->angkatan;
        }
        if ($request->filled('kelas')) {
            $tagihan = $tagihan->whereHas('siswa', function ($q) use ($request) {
                $q->where('kelas', $request->kelas);
            });
            $title = $title . ' Kelas ' . $request->kelas;
        }
        $tagihan = $tagihan->get();
        return view('operator.laporantagihan_index', compact('tagihan', 'title'));
    }
}
