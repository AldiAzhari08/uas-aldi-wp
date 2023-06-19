<?php

namespace App\Http\Controllers;

use App\Models\Detail;
use App\Models\Karyawan;
use App\Models\Jadwal;
use App\Models\User;
use Illuminate\Http\Request;
use App\Charts\DokterLineChart;

class JadwalController extends Controller
{
    public function index()
    {   
        $title = "Jadwal Jam Kerja Karyawan";
        $jadwals = Jadwal::orderBy('id','asc')->get();
        return view('jadwals.index', compact(['jadwals' , 'title']));
    }

    public function create()
    {
        $title = "Tambah Data Karyawan";
        $managers = User::where('position', '1')->orderBy('id','asc')->get();
        return view('jadwals.create', compact('title', 'managers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'no_ship' => 'required'
        ]);

        $jadwal = [
            'no_ship' => $request->no_ship,
            'tanggal' => $request->tanggal,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
        ];
        if($result = Jadwal::create($jadwal)){
            for ($i=1; $i <= $request->jml; $i++) { 
                $details = [
                    'no_ship' => $request->no_ship,
                    'id_karyawan' => $request['id_karyawan'.$i],
                    'bagian' => $request['bagian'.$i],
                    'keterangan' => $request['keterangan'.$i],
                    
                ];
                Detail::create($details);
            }
        }
        return redirect()->route('jadwals.index')->with('success','Karyawan has been created successfully.');
    }

    public function show(Jadwal $jadwal)
    {
        return view('jadwals.show',compact('Departement'));
    }

    public function edit(Jadwal $jadwals)
    {
        $title = "Edit Data Karyawan";
        $managers = User::where('position', '1')->orderBy('id','asc')->get();
        $detail = Detail::where('no_karyawan', $jadwals->id_karyawan)->orderBy('id','asc')->get();
        return view('jadwals.edit',compact('jadwals' , 'title', 'managers', 'detail'));
    }

    public function update(Request $request, Dokter $jadwals)
    {
        $jadwals = [
            'id_dokter' => $request->id_dokter,
            'nama_dokter' => $request->nama_dokter,
            'bulan' => $request->bulan,
            'spesialisasi' => $request->spesialisasi,
            // 'total' => $request->total,
        ];
        if ($jadwals->fill($jadwals)->save()){
            Detail::where('no_dok', $jadwals->id_dokter)->delete();
            for ($i=1; $i <= $request->jml; $i++) { 
                $details = [
                    'no_dok' => $dokter->id_dokter,
                    'id_jadwal' => $request['id_jadwal'.$i],
                    'nama_dokter' => $request['nama_dokter'.$i],
                    'bulan' => $request['bulan'.$i],
                    'spesialisai' => $request['spesialisai'.$i],
                    'tempat_praktik' => $request['tempat_praktik'.$i],
                    'keterangan' => $request['keterangan'.$i],
                ];
                Detail::create($details);
            }
        }
        return redirect()->route('dokters.index')->with('success','Departement Has Been updated successfully');
    }

    public function destroy(Dokter $dokter)
    {
        $dokter->delete();
        return redirect()->route('dokters.index')->with('success','Departement has been deleted successfully');
    }

    public function exportPdf()
    {
        $title = "Laporan Data Karyawan";
        $dokters = Dokter::orderBy('id', 'asc')->get();

        $pdf = PDF::loadview('dokters.pdf', compact(['dokters', 'title']));
        return $pdf->stream('laporan-dokters-pdf');
    }

    public function chartLine()
    {
        $api = url(route('dokters.chartLineAjax'));
   
        $chart = new DokterLineChart;
        $chart->labels(['Ibu dan Anak', 'THT', 'Jantung', 'Mata', 'Kandungan', 'Kulit', 'Penyakit Dalam'])->load($api);
        $title = "Chart Ajax";
        return view('chart', compact('chart', 'title'));
    }
   
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function chartLineAjax(Request $request)
    {
        $year = $request->has('year') ? $request->year : date('Y');
        $dokters = Dokter::select(\DB::raw("COUNT(*) as count"))
                    ->where('bulan', 'LIKE', '%'.$year. '%')
                    ->groupBy(\DB::raw("spesialisasi"))
                    ->pluck('count');
  
        $chart = new DokterLineChart;
  
        $chart->dataset('Dokter Spesialis Chart', 'line', $dokters)->options([
                    'fill' => 'true',
                    'borderColor' => '#51C1C0'
                ]);
  
        return $chart->api();
    }

}
