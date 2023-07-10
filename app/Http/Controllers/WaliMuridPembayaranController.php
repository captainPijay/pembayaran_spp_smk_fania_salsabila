<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Support\Facades\Notification;
use App\Models\Bank;
use App\Models\User;
use App\Models\Tagihan;
use App\Models\WaliBank;
use App\Models\Pembayaran;
use App\Models\BankSekolah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Notifications\PembayaranNotification;
use Storage;

class WaliMuridPembayaranController extends Controller
{
    public function index()
    {
        $pembayaran = Pembayaran::where('wali_id', Auth()->user()->id)
            ->latest()
            ->orderBy('tanggal_konfirmasi', 'desc')
            ->paginate(50);
        $data['models'] = $pembayaran;
        return view('wali.pembayaran_index', $data);
    }
    public function show(Pembayaran $pembayaran)
    {
        auth()->user()->unreadNotifications->where('id', request('id'))->first()?->markAsRead();
        return view('wali.pembayaran_show', [
            'model' => $pembayaran,
            'route' => ['pembayaran.update', $pembayaran->id]
        ]);
    }
    public function create(Request $request)
    {
        $data['listWaliBank'] = WaliBank::where('wali_id', Auth::user()->id)->get()->pluck('nama_bank_full', 'id');
        $data['tagihan'] = Tagihan::waliSiswa()->findOrFail($request->tagihan_id);
        // $data['bankSekolah'] = BankSekolah::findOrfail($request->bank_sekolah_id);
        $data['model'] = new Pembayaran();
        $data['method'] = 'POST';
        $data['route'] = 'wali.pembayaran.store';
        $data['listBankSekolah'] = BankSekolah::pluck('nama_bank', 'id'); //ambil nama bank dan value id
        $data['listBank'] = Bank::pluck('nama_bank', 'id'); //ambil nama bank dan value id
        if ($request->bank_sekolah_id != null) {
            $data['bankYangDipilih'] = BankSekolah::findOrfail($request->bank_sekolah_id);
        }
        $data['url'] = route('wali.pembayaran.create', [
            'tagihan_id' => $request->tagihan_id
        ]);
        return view('wali.pembayaran_form', $data);
    }
    public function store(Request $request)
    {
        $waliBank = '';
        if ($request->wali_bank_id == null && $request->nomor_rekening == null) {
            flash()->addError('Silahkan Pilih Bank Pengirim');
            return back();
        }
        if ($request->nama_rekening != null && $request->nomor_rekening != null) {
            #wali membuat rekening baru
            $bankId = $request->bank_id;
            // $namaRekeningPengirim = $request->nama_rekening_pengirim;
            // $nomorRekeningPengirim = $request->nomor_rekening_pengirim;
            $bank = Bank::findOrFail($bankId);
            if ($request->filled('simpan_data_rekening')) {
                //simpan data rekening pengirim
                $requestDataBank = $request->validate([
                    'nama_rekening' => 'required',
                    'nomor_rekening' => 'required|min:8|max:16'
                ]);
                // $waliBank = new WaliBank();
                // $waliBank->nama_rekening = $requestDataBank['nama_rekening_pengirim'];
                // $waliBank->nomor_rekening = $requestDataBank['nomor_rekening_pengirim'];
                // $waliBank->wali_id = Auth::user()->id;
                // $waliBank->kode = $bank->sandi_bank;
                // $waliBank->nama_bank = $bank->nama_bank;
                // $waliBank->save();
                $waliBank = WaliBank::firstOrCreate(
                    //jika nomor dan nama rekening sudah ada maka jangan di simpan, namun jika belum ada maka masuk ke create karna nama method nya first or create
                    $requestDataBank,
                    [
                        'nama_rekening' => $requestDataBank['nama_rekening'],
                        'wali_id' => Auth::user()->id,
                        'kode' => $bank->sandi_bank,
                        'nama_bank' => $bank->nama_bank,
                    ]
                );
            }
        } else {
            //ambil data wali bank dan tidak di simpan
            $waliBankId = $request->wali_bank_id;
            $waliBank = WaliBank::findOrFail($waliBankId);
            #wali memilih dari select
        }

        $jumlahDibayar = str_replace('.', '', $request->jumlah_dibayar);

        $validasiPembayaran = Pembayaran::where('jumlah_dibayar', $jumlahDibayar)
            ->where('tagihan_id', $request->tagihan_id)
            ->first();
        if ($validasiPembayaran != null) {
            flash()->addWarning('Data Pembayaran Ini Sudah Ada Dan Akan Segera Di Konfirmasi Oleh Operator', 'Sudah Dibayar');
            return back();
        }
        $request->validate([
            'tanggal_bayar' => 'required',
            'jumlah_dibayar' => 'required',
            'bukti_bayar' => 'required|image|mimes:jpeg,png,jpg|max:5048'
        ]);
        $buktiBayar = $request->file('bukti_bayar')->store('public');
        $dataPembayaran = [
            'bank_sekolah_id' => $request->bank_sekolah_id,
            'tagihan_id' => $request->tagihan_id,
            'wali_id' => auth()->user()->id,
            'tanggal_bayar' => $request->tanggal_bayar,
            // 'status_konfirmasi' => 'belum',
            'jumlah_dibayar' => $jumlahDibayar,
            'bukti_bayar' => $buktiBayar,
            'metode_pembayaran' => 'transfer',
            'user_id' => 0
        ];
        if ($request->simpan_data_rekening) {
            $dataPembayaran['wali_bank_id'] = $waliBank->id;
        }
        $tagihan = Tagihan::findOrFail($request->tagihan_id);
        //validasi pembayaran harus lunas
        if ($jumlahDibayar >= $tagihan->total_tagihan) {
            DB::beginTransaction();
            try {
                $pembayaran = Pembayaran::create($dataPembayaran);
                $userOperator = User::where('akses', 'operator')->get();
                Notification::send($userOperator, new PembayaranNotification($pembayaran));
                DB::commit();
            } catch (\Throwable $th) {
                DB::rollBack();
                flash()->addError('Gagal Menyimpan Pembayaran, ' . $th->getMessage());
                return back();
            }
            flash('Pembayaran Berhasil Di Simpan Dan Akan Segera Di Konfirmasi Oleh Operator');
            return redirect()->route('wali.pembayaran.show', $pembayaran->id);
        } else {
            flash('Jumlah Pembayaran Tidak Boleh Kurang Dari Total Tagihan');
            return back();
        }
    }

    public function destroy($id)
    {
        $pembayaran = Pembayaran::findOrFail($id);
        if ($pembayaran->tanggal_konfirmasi != null) {
            flash()->addError('Data Pembayaran Ini Sudah Di Konfirmasi, Tidak Bisa Di Hapus', 'Gagal');
            return back();
        }
        Storage::delete($pembayaran->bukti_bayar);
        $pembayaran->delete();
        flash()->addError('Data Pembayaran Berhasil Di Hapus', 'Berhasil');
        return redirect()->route('wali.pembayaran.index');
    }
}
