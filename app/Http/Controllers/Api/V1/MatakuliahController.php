<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMataKuliahRequest;
use App\Http\Requests\UpdateMataKuliahRequest;
use App\Http\Resources\V1\MataKuliahResource;
use App\Models\MataKuliah;
use Illuminate\Http\Request;

class MataKuliahController extends Controller
{
    public function index(Request $request)
    {
        $query = MataKuliah::with('programStudi')->latest('id');

        // Pencarian kode atau nama mata kuliah.
        if ($request->filled('cari')) {
            $keyword = $request->input('cari');

            $query->where(function ($q) use ($keyword) {
                $q->where('nama_mk', 'like', "%{$keyword}%")
                    ->orWhere('kode_mk', 'like', "%{$keyword}%");
            });
        }

        // Filter berdasarkan program studi.
        if ($request->filled('prodi')) {
            $query->where(
                'program_studi_id',
                $request->input('prodi')
            );
        }

        $data = $query->paginate(10)->withQueryString();

        return MataKuliahResource::collection($data);
    }

    public function store(StoreMataKuliahRequest $request)
    {
        $mataKuliah = MataKuliah::create(
            $request->validated()
        );

        $mataKuliah->load('programStudi');

        return (new MataKuliahResource($mataKuliah))
            ->response()
            ->setStatusCode(201);
    }

    public function show(MataKuliah $mataKuliah)
    {
        return new MataKuliahResource(
            $mataKuliah->load('programStudi')
        );
    }

    public function update(
        UpdateMataKuliahRequest $request,
        MataKuliah $mataKuliah
    ) {
        $mataKuliah->update($request->validated());
        $mataKuliah->load('programStudi');

        return new MataKuliahResource($mataKuliah);
    }

    public function destroy(MataKuliah $mataKuliah)
    {
        $mataKuliah->delete();

        return response()->noContent();
    }
}