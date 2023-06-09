<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Biaya;
use App\Models\Siswa;
use App\Models\Tagihan;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use App\Models\TagihanDetail;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreTagihanRequest;
use App\Http\Requests\UpdateTagihanRequest;
use App\Notifications\TagihanNotification;
use Illuminate\Support\Facades\Notification;

class TagihanController extends Controller
{
    private $viewIndex = 'tagihan_index';
    private $viewCreate = 'tagihan_form';
    private $viewEdit = 'tagihan_form';
    private $viewShow = 'tagihan_show';
    private $routePrefix = 'tagihan';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->filled('bulan') && $request->filled('tahun')) {
            $models = Tagihan::latest()->whereMonth('tanggal_tagihan', $request->bulan)
                ->whereYear('tanggal_tagihan', $request->tahun)
                ->paginate(50);
        } else {

            $models = Tagihan::latest()->paginate(50);
        }
        return view('operator.' . $this->viewIndex,  [
            'models' => $models,
            'routePrefix' => $this->routePrefix,
            'title' => 'DATA TAGIHAN'

        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $siswa = Siswa::all();
        $data = [
            'model' => new Tagihan(),
            'method' => 'POST',
            'route' => $this->routePrefix . '.store',
            'button' => 'SIMPAN',
            'title' => 'Data Tagihan',
            // 'angkatan' => $siswa->pluck('angkatan', 'angkatan'),
            // 'kelas' => $siswa->pluck('kelas', 'kelas'),
            // 'biaya' => Biaya::get()
        ];
        return view('operator.' . $this->viewCreate, $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTagihanRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTagihanRequest $request)
    {
        $requestData = $request->validated();

        DB::beginTransaction();

        //ambil semua data siswa dengan status aktif
        $siswa = Siswa::currentStatus('aktif')->get();
        // if ($requestData['kelas'] != '') {
        //     $siswa->where('kelas', $requestData['kelas']);
        // }
        // if ($requestData['angkatan'] != '') {
        //     $siswa->where('angkatan', $requestData['angkatan']);
        // }
        foreach ($siswa as $itemSiswa) {
            $requestData['siswa_id'] = $itemSiswa->id;
            $requestData['status'] = 'baru';
            $tanggalTagihan = Carbon::parse($requestData['tanggal_tagihan']);
            $bulanTagihan = $tanggalTagihan->format('m');
            $tahunTagihan = $tanggalTagihan->format('Y');
            // $cekTagihan = Tagihan::where('siswa_id', $itemSiswa->id)->first();
            // ->whereMonth('tanggal_tagihan', $bulanTagihan)
            // ->whereYear('tanggal_tagihan', $tahunTagihan)
            // ->first();
            // if ($cekTagihan == null) {
            $tagihan = Tagihan::create($requestData);
            Notification::send($tagihan->siswa->wali, new TagihanNotification($tagihan));
            $biaya = $itemSiswa->biaya->children;
            foreach ($biaya as $itemBiaya) {
                $detail = TagihanDetail::create([
                    'tagihan_id' => $tagihan->id,
                    'nama_biaya' => $itemBiaya->nama,
                    'jumlah_biaya' => $itemBiaya->jumlah,
                ]);
                // }
            }
        }
        DB::commit(); //Metode DB::commit() digunakan untuk mengakhiri transaksi yang sukses. Ini mengonfirmasi bahwa semua perintah dalam transaksi telah berhasil dieksekusi dan perubahan-perubahan tersebut harus diterapkan ke basis data secara permanen.
        flash("Data tagihan berhasil disimpan")->success();
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tagihan  $tagihan
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $tagihan = Tagihan::with('pembayaran')->findOrFail($id);
        $data['tagihan'] = $tagihan;
        $data['siswa'] = $tagihan->siswa;
        $data['periode'] = Carbon::parse($tagihan->tanggal_tagihan)->translatedFormat('F Y');
        $data['model'] = new Pembayaran();
        return view('operator.' . $this->viewShow, $data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tagihan  $tagihan
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $payment = Tagihan::findOrFail($id);
        $payment->delete();
        $detailTagihan = TagihanDetail::where('tagihan_id', $id);
        $detailTagihan->delete();
        flash('Data Telah Berhasil Di Hapus', 'danger');
        return back();
    }
}
