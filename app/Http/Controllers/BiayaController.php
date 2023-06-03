<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Biaya;
use App\Http\Requests\StoreBiayaRequest;
use App\Http\Requests\UpdateBiayaRequest;
use Illuminate\Http\Request;
use Storage;

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
        $models = Biaya::with('user')->latest()->paginate(50);
        if ($request->filled('search')) {
            $models = Biaya::with('user')->search($request->search)->latest()->paginate(50);
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
    public function create()
    {
        $data = [
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
        flash('Data Berhasil Di Simpan')->success();
        return redirect()->route($this->routePrefix . '.index');
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
        flash('Data Berhasil Di Ubah')->warning();
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
        $model->delete();
        flash('Data Berhasil Di Hapus', 'danger');
        return back();
    }
}
