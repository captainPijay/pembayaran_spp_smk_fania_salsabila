<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Siswa;
use Illuminate\Http\Request;

class BerandaOperatorController extends Controller
{
    public function index()
    {
        $siswa = Siswa::currentStatus('aktif')->get();
        $pembayaran = Pembayaran::get();
        $kas = 0;
        foreach ($pembayaran as $item) {
            if ($item->tanggal_konfirmasi != null) {
                $kas += $item->jumlah_dibayar;
            }
        }
        $dataBayar = formatRupiah($kas);
        return view('operator.beranda_index', [
            'siswa' => $siswa,
            'kas' => $dataBayar
        ]);
    }
}
