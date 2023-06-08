<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    public function update(Request $request)
    {
        if ($request->model == 'siswa') {
            $model = Siswa::findOrFail($request->id);
            $model->setStatus($request->status);
            $model->save();
            if ($model->status == 'aktif') {
                flash("Berhasil Melakukan Aktivasi Siswa")->success();
            } else {
                flash("Berhasil Menonaktifkan Siswa", 'danger');
            }
            return back();
        }
    }
}
