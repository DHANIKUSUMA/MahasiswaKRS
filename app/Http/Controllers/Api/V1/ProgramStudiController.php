<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProgramStudi;
use App\Http\Resources\V1\ProgramStudiResource;

class ProgramStudiController extends Controller
{
    public function index(){
        $programStudi = ProgramStudi::orderBy('nama')->get();

        return ProgramStudiResource::collection($programStudi);
    }
}
