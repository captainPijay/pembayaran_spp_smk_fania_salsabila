<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\UserImport;
use App\Models\User as Model;
use App\Models\User;
use Excel;

class UserController extends Controller
{
    private $viewIndex = 'user_index';
    private $viewCreate = 'user_form';
    private $viewEdit = 'user_form';
    private $viewShow = 'user_form';
    private $routePrefix = 'user';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $models = Model::latest()->paginate(50);
        return view('operator.' . $this->viewIndex, [
            'models' => Model::where('akses', '<>', 'wali')->latest()->paginate(settings()->get('app_pagination', '1')),
            'title' => 'Data User',
            'routePrefix' => $this->routePrefix
        ]);
    }
    public function userImportExcel(Request $request)
    {
        try {
            $file = $request->file('file');
            $namaFile = $file->getClientOriginalName();
            $formatFile = $file->getClientOriginalExtension(); // Mendapatkan ekstensi file

            // Cek format file
            if ($formatFile == 'xlsx') {
                // Proses import data
                $file->move('DataUser', $namaFile);
                $import = new UserImport();

                // Memvalidasi kolom NISN
                $collection = Excel::toCollection($import, public_path('/DataUser/' . $namaFile));
                $condition = false;

                //flatten tu kan kolom excel berbeda makanya jadi array 2 dimensi nah dengan flatten di jadikan 1 dimensi agar bisa di loop seperti foreach
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
            'title' => 'Data User'
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
            'akses' => 'required|in:operator,admin,wali',
            'password' => 'required'
        ]);
        $requestData['password'] = bcrypt($requestData['password']);
        $requestData['nohp_verified_at'] = now();
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
        //
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
            'title' => 'Data User'
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
            'akses' => 'required|in:operator,wali,admin',
            'password' => 'nullable'
        ]);
        if ($id == 1 && $request->akses != "operator") {
            flash()->addError("Data Tidak Dapat Dirubah Karena Alasan Hak Akses");
            return back();
        }
        if ($requestData['password'] == null) {
            unset($requestData['password']);
        } else {
            $requestData['password'] = bcrypt($requestData['password']);
        }
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
        $model = Model::findOrFail($id);

        if ($model->id == 1) {
            flash()->addError('Data Tidak Bisa Di Hapus');
            return back();
        }
        $model->delete();
        flash()->addError('Data Berhasil Di Hapus', 'Berhasil');
        return back();
    }
}
