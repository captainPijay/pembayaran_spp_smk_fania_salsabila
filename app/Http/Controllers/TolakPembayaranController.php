<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Tagihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Notification;
use App\Notifications\TolakPembayaranNotification;

class TolakPembayaranController extends Controller
{
    public function tolakPembayaran($id)
    {
        $pembayaran = Pembayaran::findOrFail($id);
        if ($pembayaran->bukti_bayar) {
            Storage::delete($pembayaran->bukti_bayar);
        }
        $wali = $pembayaran->wali;
        if ($wali != null) {
            Notification::send($wali, new TolakPembayaranNotification($pembayaran));
        }
        // foreach ($pay as $item) {
        //     $item->delete();
        // }
        // TagihanDetail::where('tagihan_id', $detail->id)->delete();
        $pembayaran->delete();
        flash()->addError('Data Pembayaran Berhasil Di Hapus', 'Berhasil');
        return redirect('operator/pembayaran');
    }
    public function readAll()
    {
        $a = auth()->user()->unreadNotifications;
        foreach ($a as $item) {
            $item->markAsRead();
            $item->delete();
        }
        flash()->addWarning('Berhasil Melihat Semua Notifikasi');
        return back();
    }
}
