<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class KuliahLapanganRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */

    public function __construct(\Illuminate\Http\Request $request)
    {
        $request->merge([
            'created_by' => Auth::user()->id,
        ]);
    }
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
        // $this->request->add(['admin_fakultas_id' => Auth::user()->adminFakultas->id]);
        return [
            'tahun_akademik_id' => 'required',
            'created_by' => 'required',
            'kuliah_lapangan_nama' => 'required',
            'waktu_daftar_mulai' => 'required',
            'waktu_daftar_selesai' => 'required|date|after_or_equal:waktu_daftar_mulai',
            'waktu_publikasi_kelompok' => 'required|date',
            'waktu_pelaksanaan_mulai' => 'required|date',
            'waktu_pelaksanaan_selesai' => 'required|date|after_or_equal:waktu_pelaksanaan_mulai',
            'waktu_tugas_mulai' => 'required|date',
            'waktu_tugas_selesai' => 'required|date|after_or_equal:waktu_tugas_mulai',
            'waktu_penilaian_mulai' => 'required|date',
            'waktu_penilaian_selesai' => 'required|date|after_or_equal:waktu_penilaian_mulai',
            'is_daftar_open' => 'nullable',
            'is_active' => 'nullable',
            'is_ppl' => 'nullable',
            'keterangan' => 'nullable',
        ];
    }
    public function messages()
    {
        return [
            'required' => ':attribute harus diisi',
            'date' => ':attribute harus format tanggal',
            'after_or_equal' => 'tanggal selesai harus lebih besar dari tanggal mulai'
        ];
    }
    public $validator = null;
    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $this->validator = $validator;
    }
}
