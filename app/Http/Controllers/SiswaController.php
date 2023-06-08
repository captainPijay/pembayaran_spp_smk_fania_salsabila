<?php

namespace App\Http\Controllers;

use Storage;
use App\Models\User;
use App\Models\Siswa;
use App\Models\Tagihan;
use Illuminate\Http\Request;
use App\Http\Requests\StoreSiswaRequest;
use App\Http\Requests\UpdateSiswaRequest;
use App\Models\Biaya;

class SiswaController extends Controller
{
    private $viewIndex = 'siswa_index';
    private $viewCreate = 'siswa_form';
    private $viewEdit = 'siswa_form';
    private $viewShow = 'siswa_show';
    private $routePrefix = 'siswa';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $models = Siswa::with('wali', 'user')->latest()->paginate(50);
        if ($request->filled('search')) {
            $models = Siswa::with('wali', 'user')->search($request->search)->latest()->paginate(50);
        }
        return view('operator.' . $this->viewIndex,  [
            'models' => $models,
            'routePrefix' => $this->routePrefix,
            'title' => 'DATA SISWA'

        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'listBiaya' => Biaya::has('children')->whereNull('parent_id')->pluck('nama', 'id'),
            'model' => new Siswa(),
            'method' => 'POST',
            'route' => $this->routePrefix . '.store',
            'button' => 'SIMPAN',
            'title' => 'Data Siswa',
            'wali' => User::where('akses', 'wali')->pluck('name', 'id')
        ];
        return view('operator.' . $this->viewCreate, $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSiswaRequest $request)
    {
        $requestData = $request->validated();
        // $validasi = [
        //     'wali_id.nullable' => 'Boleh Kosong',
        //     'nama.required' => 'Nama Diperlukan',
        //     'jenis_kelamin.required' => 'Jenis Kelamin Diperlukan',
        //     'nisn.required' => 'NISN Diperlukan',
        //     'nisn.unique' => 'NISN Tidak Boleh Sama',
        //     'jurusan.required' => 'Jurusan Di Perlukan',
        //     'kelas.required' => 'Kelas Diperlukan',
        //     'angkatan.required' => 'Angkatan Diperlukan',
        //     'foto.nullable' => 'Boleh Kosong',
        //     'foto.image' => 'Harus Berupa Gambar',
        //     'foto.mimes' => 'Format Harus : jpeg,png,jpg',
        //     'foto.max' => 'Ukuran Maksimal 5MB'
        // ];
        // $requestData = $request->validate($rules, $validasi);
        if ($request->hasFile('foto')) {
            $requestData['foto'] = $request->file('foto')->store('public');
        }
        //cara zahran
        // if($requestData['wali_id'] != null){
        //     $requestData['wali_status'] = 'ok';
        // }

        //cara zahran 2
        // if($request->wali_id != null){
        //     $requestData['wali_status'] = 'ok';
        // }
        if ($request->filled('wali_id')) {
            $requestData['wali_status'] = 'ok';
        } else {
            $requestData['wali_status'] = null;
        }
        $requestData['user_id'] = auth()->user()->id;
        $siswa = Siswa::create($requestData);
        $siswa->setStatus('aktif');
        flash('Data Berhasil Di Simpan')->success();
        return redirect()->route($this->routePrefix . '.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Siswa  $siswa
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $siswa = Siswa::findOrFail($id);
        return view('operator.' . $this->viewShow, [
            'model' => $siswa,
            'title' => 'Detail Siswa'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Siswa  $siswa
     * @return \Illuminate\Http\Response
     */
    public function edit(Siswa $siswa)
    {
        $data = [
            'listBiaya' => Biaya::has('children')->whereNull('parent_id')->pluck('nama', 'id'),
            'model' => $siswa,
            'method' => 'PUT',
            'route' => [$this->routePrefix . '.update', $siswa],
            'button' => 'UPDATE',
            'title' => 'FORM UPDATE DATA SISWA',
            'wali' => User::where('akses', 'wali')->pluck('name', 'id')
        ];
        return view('operator.' . $this->viewCreate, $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSiswaRequest  $request
     * @param  \App\Models\Siswa  $siswa
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSiswaRequest $request, $id)
    {
        $requestData = $request->validated();
        $model = Siswa::findOrFail($id);
        if ($request->hasFile('foto') && $model->foto != null) {
            Storage::delete($model->foto);
            $requestData['foto'] = $request->file('foto')->store('public');
        }
        if ($request->hasFile('foto') && $model->foto == null) {
            $requestData['foto'] = $request->file('foto')->store('public');
        }
        if ($request->filled('wali_id')) {
            $requestData['wali_status'] = 'ok';
        } else {
            $requestData['wali_status'] = null;
        }
        $requestData['user_id'] = auth()->user()->id;
        Siswa::where('id', $id)->update($requestData);
        flash('Data Berhasil Di Ubah')->warning();
        return redirect()->route($this->routePrefix . '.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Siswa  $siswa
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = Siswa::findOrFail($id);
        if (Tagihan::firstWhere('siswa_id', $id) != null) {
            $tagihan = Tagihan::where('siswa_id', $id)->get();
            $tagihan->delete();
        }
        if ($model->foto != null) {
            Storage::delete($model->foto);
            $model->delete();
        } else {
            $model->delete();
        }

        flash('Data Berhasil Di Hapus', 'danger');
        return back();
    }
}
