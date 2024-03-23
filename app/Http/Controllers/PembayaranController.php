<?php

namespace App\Http\Controllers;

use App\Http\Middleware\Wali;
use App\Http\Requests\StorePembayaranRequest;
use App\Http\Requests\UpdatePembayaranRequest;
use App\Models\Pembayaran;
use App\Models\Tagihan;
use App\Notifications\PembayaranKonfirmasiNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Storage;

class PembayaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $models = Pembayaran::latest()->orderBy('tanggal_konfirmasi', 'desc');
        if ($request->filled('bulan')) {
            $models = $models->whereMonth('tanggal_bayar', $request->bulan);
        }
        if ($request->filled('tahun')) {
            $models = $models->whereYear('tanggal_bayar', $request->tahun);
        }
        if ($request->filled('status')) {
            if ($request->status == 'sudah-konfirmasi') {
                $models = $models->whereNotNull('tanggal_konfirmasi');
            }
            if ($request->status == 'belum-konfirmasi') {
                $models = $models->whereNull('tanggal_konfirmasi');
            }
        }
        if ($request->filled('q')) {
            $models = $models->search($request->q, null, true);
        }
        $data['models'] = $models->paginate(settings()->get('app_pagination', '50'));
        $data['title'] = 'Data Pembayaran';
        return view('operator.pembayaran_index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePembayaranRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePembayaranRequest $request)
    {
        $requestData = $request->validated();
        // $requestData['status_konfirmasi'] = 'sudah';
        $requestData['tanggal_konfirmasi'] = now();
        $requestData['metode_pembayaran'] = 'manual';
        $tagihan = Tagihan::findOrFail($requestData['tagihan_id']);
        $totalDibayar = $tagihan->pembayaran->sum('jumlah_dibayar') + $requestData['jumlah_dibayar'];
        $tagihan = Tagihan::findOrFail($requestData['tagihan_id']);
        $requestData['wali_id'] = $tagihan->siswa->wali_id ?? 0;
        if ($totalDibayar >= $tagihan->total_tagihan) {
            $tagihan->status = 'lunas';
            $tagihan->tanggal_lunas = now();
        } else {
            $tagihan->status = 'angsur';
        }
        $tagihan->save();
        $pembayaran = Pembayaran::create($requestData);
        $wali = $pembayaran->wali;
        if ($wali != null) {
            Notification::send($wali, new PembayaranKonfirmasiNotification($pembayaran));
        }
        flash('Pembayaran Berhasil Dilakukan');
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pembayaran  $pembayaran
     * @return \Illuminate\Http\Response
     */
    public function show(Pembayaran $pembayaran)
    {
        auth()->user()->unreadNotifications->where('id', request('id'))->first()?->markAsRead();
        // auth()->user() merujuk pada pengguna yang sedang terotentikasi dalam sistem.
        // unreadNotifications mengambil semua notifikasi yang belum terbaca oleh pengguna tersebut.
        // where('id', request('id')) digunakan untuk mencari notifikasi dengan ID yang dikirim melalui permintaan (request) HTTP.
        // first()? digunakan untuk mengambil notifikasi pertama yang sesuai dengan ID tersebut. Jika tidak ada notifikasi yang sesuai, maka akan dikembalikan nilai null.
        // Jika notifikasi ditemukan, markAsRead() akan menandai notifikasi tersebut sebagai sudah terbaca oleh pengguna.
        return view('operator.pembayaran_show', [
            'model' => $pembayaran,
            'route' => ['pembayaran.update', $pembayaran->id],
            'routedel' => ['pembayaran-delete', $pembayaran->id],
            'title' => 'Detail Pembayaran',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pembayaran  $pembayaran
     * @return \Illuminate\Http\Response
     */
    public function edit(Pembayaran $pembayaran)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePembayaranRequest  $request
     * @param  \App\Models\Pembayaran  $pembayaran
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pembayaran $pembayaran)
    {
        // $pembayaran->status_konfirmasi = 'sudah';
        $wali = $pembayaran->wali;
        // $wali->notify(new PembayaranKonfirmasiNotification(($pembayaran))); ini kalo mau ngirim notif aja tidak ke wa gateway
        $pembayaran->tanggal_konfirmasi = now();
        $pembayaran->user_id = auth()->user()->id;
        $pembayaran->save();
        $pembayaran->tagihan->status = 'lunas';
        $pembayaran->tagihan->tanggal_lunas = $pembayaran->tanggal_bayar;
        $pembayaran->tagihan->save();
        Notification::send($wali, new PembayaranKonfirmasiNotification($pembayaran));
        flash("Data Pembayaran Berhasil Di Konfirmasi");
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pembayaran  $pembayaran
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pembayaran $pembayaran)
    {
        if ($pembayaran->bukti_bayar) {
            Storage::delete($pembayaran->bukti_bayar);
        }
        $tagihan = $pembayaran->tagihan;
        $sisaPembayaran = $tagihan->total_pembayaran - $pembayaran->jumlah_dibayar;
        if ($sisaPembayaran == 0) {
            $tagihan->status = 'baru';
            $tagihan->tanggal_lunas = null;
            $tagihan->save();
        } else if ($sisaPembayaran < $tagihan->total_tagihan) {
            $tagihan->status = 'angsur';
            $tagihan->tanggal_lunas = null;
            $tagihan->save();
        }
        // foreach ($pay as $item) {
        //     $item->delete();
        // }
        // TagihanDetail::where('tagihan_id', $detail->id)->delete();
        $pembayaran->delete();
        flash()->addError('Data Pembayaran Berhasil Di Hapus', 'Berhasil');
        return back();
    }
}
