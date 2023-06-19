<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use Illuminate\Http\Request;

class KaryawanController extends Controller
{
    public function autocomplete(Request $request)
    {
        $data = Karyawan::select("nama_karyawan as value", "id")
                    ->where('nama_karyawan', 'LIKE', '%'. $request->get('search'). '%')
                    ->get();
    
        return response()->json($data);
    }

    public function show(Karyawan $karyawans)
    {
        return response()->json($karyawans);
    }
}
