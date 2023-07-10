<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Request;

class UpdateSiswaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        // dd(Request::segment(3));
        return [
            'wali_id' => 'nullable',
            'nama' => 'required',
            'biaya_id' => 'required|exists:biayas,id',
            'jenis_kelamin' => 'required',
            'nisn' => 'required|min:8|max:13|unique:siswas,nisn,' . $this->siswa,
            'jurusan' => 'required',
            'kelas' => 'required',
            'angkatan' => 'required',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:5000'
        ];
    }
}
