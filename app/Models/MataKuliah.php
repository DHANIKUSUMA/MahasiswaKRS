<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MataKuliah extends Model
{
        protected $fillable = [
        'program_studi_id',
        'kode_mk',
        'nama_mk',
        'sks',
        'status_aktif',
        'tanggal_dibuka',
    ];

    protected function casts(): array
    {
        return [
            'sks' => 'integer',
            'status_aktif' => 'boolean',
            'tanggal_dibuka' => 'date',
        ];
    }

    public function programStudi(): BelongsTo
    {
        return $this->belongsTo(ProgramStudi::class);
    }
}
