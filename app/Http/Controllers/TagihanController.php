<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTagihanRequest;
use App\Jobs\ProcessTagihan;
use App\Models\Pembayaran;
use App\Models\Siswa;
use App\Models\Tagihan;
use App\Models\TagihanDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;

// use Illuminate\Support\Facades\DB;
// use App\Http\Requests\UpdateTagihanRequest;
// use App\Notifications\TagihanNotification;
// use Illuminate\Support\Facades\Notification;
// use phpDocumentor\Reflection\PseudoTypes\True_;
// use App\Models\User;
// use App\Models\Biaya;

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
        return view('operator.' . $this->viewIndex, [
            'models' => $models->paginate(settings()->get('app_pagination', '50')),
            'routePrefix' => $this->routePrefix,
            'title' => 'DATA TAGIHAN',

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
        //Baris ini menggabungkan data yang diterima dari $request setelah melalui proses validasi dengan data 'user_id' yang diambil dari auth()->user()->id. Dengan demikian, $requestData berisi data yang siap digunakan untuk proses selanjutnya. array merge untuk menggabungkan data array yang telah di validasi
        $requestData = array_merge($request->validated(), ['user_id' => auth()->user()->id]);
        $processTagihan = new ProcessTagihan($requestData);
        $this->dispatch($processTagihan);

        // return response()->json([
        //     'message' => 'Data Berhasil Di Simpan',
        // ], 200);
        // return redirect()->action('\Imtigger\LaravelJobStatus\ProgressController@progress', [$processTagihan->getJobStatusId()]);
        return redirect()->route('jobstatus.index', ['job_status_id' => $processTagihan->getJobStatusId()]);
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
            if ($tagihan != null && $tagihan->status == 'lunas') {
                $tanggalBayar = $tagihan->pembayaran->last()->tanggal_bayar->format('d/m/y');
            }
            $arrayData[] = [
                'bulan' => ubahNamaBulan($bulan),
                'tahun' => $tahun,
                'total_tagihan' => $tagihan->total_tagihan ?? 0,
                'status_tagihan' => ($tagihan == null) ? false : true,
                'status_pembayaran' => ($tagihan == null) ? 'Belum Bayar' : $tagihan->status,
                'tanggal_bayar' => $tanggalBayar,
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
