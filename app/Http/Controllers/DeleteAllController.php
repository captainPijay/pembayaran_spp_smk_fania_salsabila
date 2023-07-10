<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Siswa;
use App\Models\Tagihan;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use App\Models\TagihanDetail;
use Illuminate\Support\Facades\Storage;

class DeleteAllController extends Controller
{
    public function deleteAllSiswa()
    {
        $siswa = Siswa::all();
        foreach ($siswa as $data) {
            if ($data->tagihan()->count() >= 1) {
                flash()->addError('Data Tidak Bisa Dihapus Semua Karena Siswa Masih Memiliki Relasi Data Tagihan');
                return back();
            }
        }

        foreach ($siswa as $data) {
            if ($data->foto) {
                Storage::delete($data->foto);
            }
            $status = $data->status();
            if ($status) {
                $status->delete();
            }
            $data->delete();
        }

        flash()->addError('Semua Data Berhasil Dihapus', 'Berhasil');
        return back();
    }
    public function deleteAllTagihan()
    {
        $tagihan = Tagihan::all();

        foreach ($tagihan as $item) {
            if ($item->pembayaran) {
                $paymentsToDelete = $item->pembayaran->where('tagihan_id', $item->id);
                foreach ($paymentsToDelete as $payment) {
                    $payment->delete();
                }
                $detailTagihan = TagihanDetail::where('tagihan_id', $item->id);
                $detailTagihan->delete();

                $item->delete();
            }
        }
        flash()->addError('Data Telah Berhasil Di Hapus', 'Berhasil');
        return back();
    }

    public function deleteAllWali()
    {
        $models = User::where('akses', 'wali')->get();

        foreach ($models as $model) {
            if (Pembayaran::where('wali_id', $model->id)->exists()) {
                $paymentsToDelete = Pembayaran::where('wali_id', $model->id)->get();

                foreach ($paymentsToDelete as $payment) {
                    if ($payment) {
                        $payment->delete();
                    }
                }
            }
            $model->delete();
        }

        flash()->addError('Semua Data Wali Berhasil Dihapus', 'Berhasil');
        return back();
    }
}
