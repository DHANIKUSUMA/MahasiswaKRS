<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMataKuliahRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // PUT untuk data lengkap, PATCH untuk field tertentu.
        $required = $this->isMethod('PUT')
            ? 'required'
            : 'sometimes';

        return [
            'program_studi_id' => [
                $required,
                'integer',
                'exists:program_studis,id',
            ],

            'kode_mk' => [
                $required,
                'string',
                'max:20',
                Rule::unique('mata_kuliahs', 'kode_mk')
                    ->ignore($this->route('mata_kuliah')),
            ],

            'nama_mk' => [
                $required,
                'string',
                'min:3',
                'max:100',
            ],

            'sks' => [
                $required,
                'integer',
                'between:1,6',
            ],

            'status_aktif' => [
                $required,
                'boolean',
            ],

            'tanggal_dibuka' => [
                Rule::requiredIf(
                    fn () => $this->boolean('status_aktif')
                ),
                'nullable',
                'date',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'program_studi_id.required' =>
                'Program studi wajib dipilih.',
            'program_studi_id.exists' =>
                'Program studi tidak ditemukan.',

            'kode_mk.required' =>
                'Kode mata kuliah wajib diisi.',
            'kode_mk.unique' =>
                'Kode mata kuliah sudah digunakan.',

            'nama_mk.required' =>
                'Nama mata kuliah wajib diisi.',
            'nama_mk.min' =>
                'Nama mata kuliah minimal 3 karakter.',

            'sks.required' =>
                'SKS wajib diisi.',
            'sks.between' =>
                'SKS harus bernilai antara 1 sampai 6.',

            'status_aktif.required' =>
                'Status mata kuliah wajib ditentukan.',
            'tanggal_dibuka.required' =>
                'Tanggal dibuka wajib diisi jika mata kuliah aktif.',
            'tanggal_dibuka.date' =>
                'Format tanggal dibuka tidak valid.',
        ];
    }
}
