<?php

namespace App\Http\Controllers;

use App\Models\Tagihan;
use Illuminate\Http\Request;

class WaliMuridInvoiceController extends Controller
{
    public function show($id)
    {
        $tagihan = Tagihan::waliSiswa()->findOrFail($id);
        $title = "Cetak Invoice Tagihan Bulan " . $tagihan->tanggal_tagihan->translatedFormat('F Y');
        return view('invoice', compact('tagihan', 'title'));
    }
}
