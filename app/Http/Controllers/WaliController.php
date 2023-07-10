<?php

namespace App\Http\Controllers;

use App\Imports\WaliImport;
use App\Models\User;
use App\Models\Siswa;
use Illuminate\Http\Request;
use App\Models\User as Model;
use App\Models\Pembayaran;
use Excel;

class WaliController extends Controller
{
    private $viewIndex = 'wali_index';
    private $viewCreate = 'user_form';
    private $viewEdit = 'user_form';
    private $viewShow = 'wali_show';
    private $routePrefix = 'wali';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $models = Model::latest()->paginate(50);
        $model = User::wali();
        if ($request->filled('search')) {
            $model = User::search($request->search);
        }
        return view('operator.' . $this->viewIndex, [
            'models' => $model->latest()->paginate(settings()->get('app_pagination', '50')),
            'title' => 'Data Wali Murid',
            'routePrefix' => $this->routePrefix
        ]);
    }
    public function waliImportExcel(Request $request)
    {
        try {
            $file = $request->file('file');
            $namaFile = $file->getClientOriginalName();
            $formatFile = $file->getClientOriginalExtension(); // Mendapatkan ekstensi file

            // Cek format file
            if ($formatFile == 'xlsx') {
                // Proses import data
                $file->move('DataUser', $namaFile);
                $import = new WaliImport();

                // Memvalidasi kolom NISN
                $collection = Excel::toCollection($import, public_path('/DataUser/' . $namaFile));
                $condition = false;

                $collection->flatten(1)->each(function ($row) use (&$condition) {
                    $nohp = $row['nohp'];
                    $email = $row['email'];

                    // Cek apakah NISN sudah ada dalam database
                    if (User::where('nohp', $nohp)->exists() || User::where('email', $email)->exists()) {
                        // Jika NISN sudah ada, set condition menjadi true
                        $condition = true;
                        return false; // Keluar dari loop
                    }
                });

                if ($condition) {
                    // Jika ada data yang sama, kembalikan ke halaman sebelumnya dengan pesan error
                    flash()->addError('Kolom Email Atau Nomor HP Tidak Boleh Sama');
                    return back();
                }

                Excel::import($import, public_path('/DataUser/' . $namaFile));
                flash('Berhasil Import Data');
            } else {
                flash()->addError('Format file tidak valid. Harap unggah file Excel dengan format .xlsx');
            }
        } catch (\Exception $e) {
            flash()->addError('Gagal Menyimpan Data, ' . $e->getMessage());
            return back();
        }

        return back();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'model' => new Model(),
            'method' => 'POST',
            'route' => $this->routePrefix . '.store',
            'button' => 'SIMPAN',
            'title' => 'Data Wali Murid',
        ];
        return view('operator.' . $this->viewCreate, $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $requestData = $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users',
            'nohp' => 'required|min:10|max:14|unique:users',
            'password' => 'required'
        ]);
        $requestData['password'] = bcrypt($requestData['password']);
        $requestData['nohp_verified_at'] = now();
        $requestData['akses'] = 'wali';
        Model::create($requestData);
        flash('Data Berhasil Di Simpan');
        return redirect()->route($this->routePrefix . '.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $model = Model::with('siswa')->wali()->where('id', $id)->firstOrFail();
        return view('operator.' . $this->viewShow, [
            'siswa' => Siswa::pluck('nama', 'id'),
            'model' => $model,
            'title' => 'DETAIL DATA WALI MURID'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = [
            'model' => Model::firstWhere('id', $id),
            'method' => 'PUT',
            'route' => [$this->routePrefix . '.update', $id],
            'button' => 'UPDATE',
            'title' => 'Data Wali Murid',
        ];
        return view('operator.' . $this->viewEdit, $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $requestData = $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email,' . $id,
            'nohp' => 'required|min:10|max:14|unique:users,nohp,' . $id,
            'password' => 'nullable',
        ]);
        if ($requestData['password'] == null) {
            unset($requestData['password']);
        } else {
            $requestData['password'] = bcrypt($requestData['password']);
        }
        $requestData['akses'] = 'wali';
        User::where('id', $id)->update($requestData);
        flash()->addWarning('Data Berhasil Di Update', 'Berhasil');
        return redirect()->route($this->routePrefix . '.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = Model::where('akses', 'wali')->firstWhere('id', $id);
        if (Pembayaran::where('wali_id', $id)->exists()) {
            $paymentsToDelete = Pembayaran::where('wali_id', $id)->get();

            foreach ($paymentsToDelete as $payment) {
                $tagihan = $payment->tagihan;

                if ($tagihan) {
                    $tagihan->delete();
                }

                $payment->delete();
            }
        }
        $model->delete();
        flash()->addError('Data Berhasil Di Hapus', 'Berhasil');
        return back();
    }
}
