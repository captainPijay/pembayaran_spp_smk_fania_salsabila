<?php

namespace App\Http\Controllers;

use App\Models\Tagihan;
use Auth;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    public function show($id)
    {
        if (Auth::user()->akses == 'wali') {
            $tagihan = Tagihan::waliSiswa()->findOrFail($id);
        } else {
            $tagihan = Tagihan::findOrFail($id);
        }
        $title = "Cetak Invoice Tagihan Bulan " . $tagihan->tanggal_tagihan->translatedFormat('F Y');
        if (request('output') == 'pdf') {
            $pdf = Pdf::loadView('invoice', compact('tagihan', 'title'));
            $namaFile = "Invoice Tagihan " . $tagihan->siswa->nama . ' bulan' . $tagihan->tanggal_tagihan->translatedFormat('F Y') . '.pdf';
            return $pdf->download($namaFile); //bisa juga pakai stream
        }
        return view('invoice', compact('tagihan', 'title'));
    }
}
