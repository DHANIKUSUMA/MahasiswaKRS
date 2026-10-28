<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MataKuliahResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'kode_mk' => $this->kode_mk,
            'nama_mk' => $this->nama_mk,
            'sks' => $this->sks,
            'status_aktif' => $this->status_aktif,

            'tanggal_dibuka' => $this->tanggal_dibuka
                ?->format('Y-m-d'),

            'program_studi' => new ProgramStudiResource(
                $this->whenLoaded('programStudi')
            ),
        ];
    }
}
