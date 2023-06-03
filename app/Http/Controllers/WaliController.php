<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Siswa;
use Illuminate\Http\Request;
use App\Models\User as Model;

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
    public function index()
    {
        // $models = Model::latest()->paginate(50);
        return view('operator.' . $this->viewIndex, [
            'models' => Model::wali()->latest()->paginate(50),
            'title' => 'Data Wali Murid',
            'routePrefix' => $this->routePrefix
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
            'nohp' => 'required|unique:users',
            'password' => 'required'
        ]);
        $requestData['password'] = bcrypt($requestData['password']);
        $requestData['nohp_verified_at'] = now();
        $requestData['akses'] = 'wali';
        Model::create($requestData);
        flash('Data Berhasil Di Simpan')->success();
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
            'nohp' => 'required|unique:users,nohp,' . $id,
            'password' => 'nullable',
        ]);
        if ($requestData['password'] == null) {
            unset($requestData['password']);
        } else {
            $requestData['password'] = bcrypt($requestData['password']);
        }
        $requestData['akses'] = 'wali';
        User::where('id', $id)->update($requestData);
        flash('Data Berhasil Di Update')->warning();
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
        $model->delete();
        flash('Data Berhasil Di Hapus', 'danger');
        return back();
    }
}
