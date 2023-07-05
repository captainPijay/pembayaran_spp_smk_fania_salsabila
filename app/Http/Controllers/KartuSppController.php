<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Tagihan;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpParser\Node\Stmt\Return_;
use Illuminate\Support\Facades\Auth;

class KartuSppController extends Controller
{
    public function index(Request $request)
    {
        // $tagihan = Tagihan::where('siswa_id', $request->siswa_id)->get();
        if (Auth::user()->akses == 'wali') {
            $siswa = Siswa::where('wali_id', Auth::user()->id)->where('id', $request->siswa_id)
                ->firstOrFail();
        } else {
            $siswa = Siswa::findOrFail($request->siswa_id);
        }
        $tahun = $request->tahun;
        $arrayData = [];
        foreach (bulanSpp() as $bulan) {

            $tagihan = Tagihan::where('siswa_id', $request->siswa_id)
                ->whereYear('tanggal_tagihan', $tahun)
                ->whereMonth('tanggal_tagihan', $bulan)
                ->first();
            $tanggalBayar = '';
            $keterangan = '';
            if ($tagihan != null && $tagihan->status == 'lunas') {
                $tanggalBayar = $tagihan->pembayaran->first()->tanggal_bayar->format('d/m/y');
                $keterangan = 'lunas';
            }
            $arrayData[] = [
                'bulan' => ubahNamaBulan($bulan),
                'tahun' => $tahun,
                'total_tagihan' => $tagihan->total_tagihan ?? 0,
                'status_tagihan' => ($tagihan == null) ? false : true,
                'status_pembayaran' => ($tagihan == null) ? 'Belum Bayar' : $tagihan->status,
                'tanggal_bayar' => $tanggalBayar,
                'keterangan' => $keterangan
            ];
        }
        if (request('output') == 'pdf') {
            $pdf = Pdf::loadView('kartuspp_index', [
                'kartuSpp' => collect($arrayData),
                'siswa' => $siswa
            ]);
            $namaFile = "Kartu Spp" . $siswa->nama . ' Tahun' . $request->tahun . '.pdf';
            return $pdf->download($namaFile); //bisa juga pakai stream
        }
        //Siswa::firstWhere('id', $request->siswa_id);
        return view('kartuspp_index', [
            'kartuSpp' => collect($arrayData),
            'siswa' => $siswa
        ]);
    }
}
