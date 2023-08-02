<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\User;
use Illuminate\Http\Request;

class WaliMuridProfilController extends Controller
{
    public function create()
    {
        $data = [
            'model' =>  User::findOrFail(Auth::user()->id),
            'method' => 'POST',
            'route' => 'wali.profil.store',
            'button' => 'UBAH',
            'title' => 'FORM UBAH PROFIL'
        ];
        return view('wali.profil_form', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $id = Auth::user()->id;
        $requestData = $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email,' . $id,
            'nohp' => 'required|min:10|max:14|unique:users,nohp,' . $id,
            'password' => 'nullable'
        ]);
        $model = User::findOrFail($id);
        if ($requestData['password'] == null) {
            unset($requestData['password']);
        } else {
            $requestData['password'] = bcrypt($requestData['password']);
        }
        $model->fill($requestData);
        $model->save();
        flash('Data Berhasil Diubah');
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
}
