<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Biaya;
use App\Http\Requests\StoreBiayaRequest;
use App\Http\Requests\UpdateBiayaRequest;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\AssignOp\Mod;
use Storage;
use toastr;

class BiayaController extends Controller
{
    private $viewIndex = 'biaya_index';
    private $viewCreate = 'biaya_form';
    private $viewEdit = 'biaya_form';
    private $viewShow = 'biaya_show';
    private $routePrefix = 'biaya';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $models = Biaya::with('user')->whereNull('parent_id')->latest()->paginate(settings()->get('app_pagination', '50'));
        if ($request->filled('search')) {
            $models = Biaya::with('user')->whereNull('parent_id')->search($request->search)->latest()->paginate(settings()->get('app_pagination', '50'));
        }
        return view('operator.' . $this->viewIndex,  [
            'models' => $models,
            'routePrefix' => $this->routePrefix,
            'title' => 'DATA BIAYA'

        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $biaya = new Biaya();
        if ($request->filled('parent_id')) {
            $biaya = Biaya::with('children')->findOrFail($request->parent_id);
        }
        $data = [
            'parentData' => $biaya,
            'model' => new Biaya(),
            'method' => 'POST',
            'route' => $this->routePrefix . '.store',
            'button' => 'SIMPAN',
            'title' => 'Data Biaya',
        ];
        return view('operator.' . $this->viewCreate, $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBiayaRequest $request)
    {
        Biaya::create($request->validated());
        flash('Data Berhasil Di Simpan');
        // toastr()->success('Data Berhasil Di Simpan');
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Biaya  $biaya
     * @return \Illuminate\Http\Response
     */
    public function show(Biaya $biaya)
    {
        return view('operator.' . $this->viewShow, [
            'model' => $biaya,
            'title' => 'Detail Biaya'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Biaya  $biaya
     * @return \Illuminate\Http\Response
     */
    public function edit(Biaya $biaya)
    {
        $data = [
            'model' => $biaya,
            'method' => 'PUT',
            'route' => [$this->routePrefix . '.update', $biaya],
            'button' => 'UPDATE',
            'title' => 'FORM DATA BIAYA',
        ];
        return view('operator.' . $this->viewCreate, $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateBiayaRequest  $request
     * @param  \App\Models\Biaya  $biaya
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBiayaRequest $request, $id)
    {
        $model = Biaya::findOrFail($id);
        $model->update($request->validated());
        flash()->addWarning('Data Berhasil Di Update', 'Berhasil');
        return redirect()->route($this->routePrefix . '.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Biaya  $biaya
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = Biaya::findOrFail($id);
        //validasi relasi ke children
        if ($model->children->count() >= 1) {
            flash()->addError("Data Tidak Bisa Di Hapus Karena Masih Memiliki Item Biaya. Hapus Item Biaya Terlebih Dahulu");
            return back();
        }
        //validasi relasi ke tabel siswa
        if ($model->siswa->count() >= 1) {
            flash()->addError('Data Gagal Dihapus Karena Masih Memiliki Relasi Ke Data Siswa');
            return back();
        }
        $model->delete();
        flash()->addError('Data Berhasil Di Hapus', 'Berhasil');
        return back();
    }
    public function deleteItem($id)
    {
        $model = Biaya::findOrFail($id);
        $model->delete();
        flash()->addError('Data Berhasil Di Hapus', 'Berhasil');
        return back();
    }
}
