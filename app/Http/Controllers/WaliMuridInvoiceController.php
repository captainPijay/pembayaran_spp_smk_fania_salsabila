<?php

namespace App\Http\Controllers;

use App\Models\Tagihan;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class WaliMuridInvoiceController extends Controller
{
    public function show($id)
    {
        $tagihan = Tagihan::waliSiswa()->findOrFail($id);
        $title = "Cetak Invoice Tagihan Bulan " . $tagihan->tanggal_tagihan->translatedFormat('F Y');
        if (request('output') == 'pdf') {
            $pdf = Pdf::loadView('invoice', compact('tagihan', 'title'));
            $namaFile = "Invoice Tagihan " . $tagihan->siswa->nama . ' bulan' . $tagihan->tanggal_tagihan->translatedFormat('F Y') . '.pdf';
            return $pdf->download($namaFile);
        }
        return view('invoice', compact('tagihan', 'title'));
    }
}
