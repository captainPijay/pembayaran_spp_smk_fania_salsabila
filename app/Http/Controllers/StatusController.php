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
            if ($model->status()) {
                $a = $model->status();
                $a->delete();
            }
            $model->setStatus($request->status);
            $model->save();
            if ($model->status == 'aktif') {
                flash("Berhasil Melakukan Aktivasi Siswa");
            } else {
                flash()->addError("Berhasil Menonaktifkan Siswa", 'Berhasil');
            }
            return back();
        }
    }
    public function aktif()
    {
        $siswa = Siswa::all();
        foreach ($siswa as $item) {
            if ($item->status()) {
                $a = $item->status();
                $a->delete();
            }
            $item->setStatus('aktif');
        }
        flash('Berhasil Aktifkan Siswa');
        return back();
    }
    public function nonaktif()
    {
        $siswa = Siswa::all();
        foreach ($siswa as $item) {
            if ($item->status()) {
                $a = $item->status();
                $a->delete();
            }
            $item->setStatus('non-aktif');
        }
        flash('Berhasil Aktifkan Siswa');
        return back();
    }
}
