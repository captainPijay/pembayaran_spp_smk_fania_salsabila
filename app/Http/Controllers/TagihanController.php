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
use phpDocumentor\Reflection\PseudoTypes\True_;

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
        $models = Tagihan::latest();
        if ($request->filled('bulan')) {
            $models = $models->whereMonth('tanggal_tagihan', $request->bulan);
        }
        if ($request->filled('tahun')) {
            $models = $models->whereYear('tanggal_tagihan', $request->tahun);
        }
        if ($request->filled('status')) {
            $models = $models->where('status', $request->status);
        }
        if ($request->filled('q')) {
            $models = $models->search($request->q, null, true);
        }
        // if ($request->filled('bulan') && $request->filled('tahun')) {
        //     $models = Tagihan::latest()->whereMonth('tanggal_tagihan', $request->bulan)
        //         ->whereYear('tanggal_tagihan', $request->tahun)
        //         ->paginate(settings()->get('app_pagination', '50'));
        // }
        // if ($request->filled('q')) {
        //     $models = Tagihan::search($request->q)->paginate(settings()->get('app_pagination', '50'));
        // } else {
        //     $models = Tagihan::latest()->paginate(settings()->get('app_pagination', '50'));
        // }
        return view('operator.' . $this->viewIndex,  [
            'models' => $models->paginate(settings()->get('app_pagination', '50')),
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
            if ($itemSiswa->wali_id != null) {
                Notification::send($tagihan->siswa->wali, new TagihanNotification($tagihan));
            }
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

        return response()->json([
            'message' => 'Data Berhasil Di Simpan',
        ], 200);
        // flash("Data tagihan berhasil disimpan")->success();
        // return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tagihan  $tagihan
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $siswa = Siswa::findOrFail($request->siswa_id);
        $tahun = $request->tahun;
        $arrayData = [];
        foreach (bulanSpp() as $bulan) {

            $tagihan = Tagihan::where('siswa_id', $request->siswa_id)
                ->whereYear('tanggal_tagihan', $tahun)
                ->whereMonth('tanggal_tagihan', $bulan)
                ->first();
            $tanggalBayar = '';
            if ($tagihan != null && $tagihan->status != 'baru') {
                $tanggalBayar = $tagihan->pembayaran->first()->tanggal_bayar->format('d/m/y');
            }
            $arrayData[] = [
                'bulan' => ubahNamaBulan($bulan),
                'tahun' => $tahun,
                'total_tagihan' => $tagihan->total_tagihan ?? 0,
                'status_tagihan' => ($tagihan == null) ? false : true,
                'status_pembayaran' => ($tagihan == null) ? 'Belum Bayar' : $tagihan->status,
                'tanggal_bayar' => $tanggalBayar
            ];
        }
        $data['kartuSpp'] = collect($arrayData);
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
        if ($payment->pembayaran) {
            $paymentsToDelete = $payment->pembayaran->where('tagihan_id', $payment->id);
            foreach ($paymentsToDelete as $item) {
                $item->delete();
            }
        }
        $payment->delete();
        $detailTagihan = TagihanDetail::where('tagihan_id', $id);
        $detailTagihan->delete();
        flash()->addError('Data Telah Berhasil Di Hapus', 'Berhasil');
        return back();
    }
}
