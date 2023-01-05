<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MahasiswaRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'iddata' => 'required',
            'nim' => 'required',
            'nama_lengkap' => 'required',
            'jenis_kelamin' => 'required',
            'lahir_tempat' => 'required',
            'lahir_tanggal' => 'required|date',
            'no_hp' => 'required',
            'alamat' => 'required',
        ];
    }
}
