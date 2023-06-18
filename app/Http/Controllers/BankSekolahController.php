<?php

namespace App\Http\Controllers;

use App\Models\BankSekolah;
use App\Http\Requests\StoreBiayaRequest;
use App\Http\Requests\StoreBankSekolahRequest;
use App\Http\Requests\UpdateBankSekolahRequest;
use App\Models\Bank;
use Illuminate\Http\Request;
use Storage;

class BankSekolahController extends Controller
{
    private $viewIndex = 'banksekolah_index';
    private $viewCreate = 'banksekolah_form';
    private $viewEdit = 'banksekolah_form';
    private $viewShow = 'banksekolah_show';
    private $routePrefix = 'banksekolah';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $models = BankSekolah::latest()->paginate(settings()->get('app_pagination', '50'));
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
            'model' => new BankSekolah(),
            'method' => 'POST',
            'route' => $this->routePrefix . '.store',
            'button' => 'SIMPAN',
            'title' => 'Data Bank',
            'listbank' => Bank::pluck('nama_bank', 'id')
        ];
        return view('operator.' . $this->viewCreate, $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBankSekolahRequest $request)
    {
        $requestData = $request->validated();
        $bank = Bank::find($requestData['bank_id']);
        unset($requestData['bank_id']);
        $requestData['kode'] = $bank->sandi_bank;
        $requestData['nama_bank'] = $bank->nama_bank;
        BankSekolah::create($requestData);
        flash('Data Berhasil Di Simpan');
        return redirect()->route($this->routePrefix . '.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BankSekolah  $banksekolah
     * @return \Illuminate\Http\Response
     */
    public function show(BankSekolah $banksekolah)
    {
        return view('operator.' . $this->viewShow, [
            'model' => $banksekolah,
            'title' => 'Detail BankSekolah'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BankSekolah  $banksekolah
     * @return \Illuminate\Http\Response
     */
    public function edit(BankSekolah $banksekolah)
    {
        $data = [
            'model' => $banksekolah,
            'method' => 'PUT',
            'route' => [$this->routePrefix . '.update', $banksekolah],
            'button' => 'UPDATE',
            'title' => 'FORM DATA BIAYA',
            'listbank' => Bank::pluck('nama_bank', 'id')
        ];
        return view('operator.' . $this->viewCreate, $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateBankSekolahRequest  $request
     * @param  \App\Models\BankSekolah  $banksekolah
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBankSekolahRequest $request, $id)
    {
        $requestData = $request->validated();
        $bank = Bank::find($requestData['bank_id']);
        unset($requestData['bank_id']);
        $requestData['kode'] = $bank->sandi_bank;
        $requestData['nama_bank'] = $bank->nama_bank;
        $model = BankSekolah::findOrFail($id);
        $model->update($request->validated());
        flash()->addWarning('Data Berhasil Di Ubah', 'Berhasil');
        return redirect()->route($this->routePrefix . '.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BankSekolah  $banksekolah
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = BankSekolah::findOrFail($id);
        $model->delete();
        flash()->addError('Data Berhasil Di Hapus', 'Berhasil');
        return back();
    }
}
