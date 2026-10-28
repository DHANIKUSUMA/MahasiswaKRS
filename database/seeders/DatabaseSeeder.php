<?php

namespace Database\Seeders;

use App\Models\MataKuliah;
use App\Models\ProgramStudi;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $si = ProgramStudi::firstOrCreate(
            ['kode_prodi' => 'SI'],
            ['nama' => 'Sistem Informasi']
        );

        $ti = ProgramStudi::firstOrCreate(
            ['kode_prodi' => 'TI'],
            ['nama' => 'Teknik Informatika']
        );

        $mi = ProgramStudi::firstOrCreate(
            ['kode_prodi' => 'MI'],
            ['nama' => 'Manajemen Informatika']
        );

        MataKuliah::firstOrCreate(
            ['kode_mk' => 'IF101'],
            [
                'program_studi_id' => $si->id,
                'nama_mk' => 'Pemrograman Web',
                'sks' => 3,
                'status_aktif' => true,
                'tanggal_dibuka' => '2026-08-01',
            ]
        );

        MataKuliah::firstOrCreate(
            ['kode_mk' => 'IF102'],
            [
                'program_studi_id' => $si->id,
                'nama_mk' => 'Basis Data',
                'sks' => 3,
                'status_aktif' => true,
                'tanggal_dibuka' => '2026-08-01',
            ]
        );

        MataKuliah::firstOrCreate(
            ['kode_mk' => 'TI101'],
            [
                'program_studi_id' => $ti->id,
                'nama_mk' => 'Algoritma dan Pemrograman',
                'sks' => 4,
                'status_aktif' => true,
                'tanggal_dibuka' => '2026-08-01',
            ]
        );

        MataKuliah::firstOrCreate(
            ['kode_mk' => 'MI101'],
            [
                'program_studi_id' => $mi->id,
                'nama_mk' => 'Pengantar Teknologi Informasi',
                'sks' => 2,
                'status_aktif' => false,
                'tanggal_dibuka' => null,
            ]
        );

    }
}