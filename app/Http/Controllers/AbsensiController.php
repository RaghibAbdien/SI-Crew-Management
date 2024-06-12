<?php

namespace App\Http\Controllers;

use App\Models\Crew;
use App\Models\Absensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Rap2hpoutre\FastExcel\FastExcel;
use Illuminate\Validation\ValidationException;

class AbsensiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $crews = Crew::all();
        $absensis = Absensi::join('crews', 'absensis.id_crew', '=', 'crews.id_crew')
        ->select('absensis.*', 'crews.nama_crew')
        ->get();
        return view('pages.absensi', compact('crews', 'absensis'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'id_crew' => 'required|exists:crews,id_crew',
                'kehadiran' => 'required|date',
            ]);

            Absensi::create([
                'id_crew' => $request->input('id_crew'),
                'kehadiran' => $request->input('kehadiran'),
            ]);

            return redirect()->route('absensi-crew')->with('success', 'Data berhasil ditambahkan');
        } catch (ValidationException $e) {
            // Jika terjadi kesalahan validasi, kembali ke halaman sebelumnya dengan pesan kesalahan
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e){
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function exportAbsensi()
    {
        // Ambil semua data absensi
        $dataAbsensi = DB::table('absensis')
        ->join('crews', 'absensis.id_crew', '=', 'crews.id_crew')
        ->select('crews.nama_crew', 'absensis.kehadiran')
        ->get();
        $no = 1;

        // Debug: Log jumlah data yang diambil
        Log::info('Jumlah data absensi yang diambil: ' . $dataAbsensi->count());

        // Jika tidak ada data, log dan return error message
        if ($dataAbsensi->isEmpty()) {
            Log::warning('Tidak ada data absensi yang tersedia untuk diekspor.');
            return response()->json(['error' => 'Tidak ada data absensi yang tersedia untuk diekspor.'], 404);
        }

        try {
            return (new FastExcel($dataAbsensi))->download('data-absensi-crew.xlsx', function ($item) use (&$no) {
                // Debug: Log setiap item yang diproses
                Log::info('Memproses item: ' . json_encode($item));

                // Periksa apakah $item->crews dan $item->kehadiran ada
                if (!$item->nama_crew || !$item->kehadiran) {
                    Log::error('Data item tidak lengkap: ' . json_encode($item));
                    throw new \Exception('Data item tidak lengkap.');
                }

                return [
                    'No.' => $no++,
                    'Nama Crew' => $item->nama_crew,
                    'Waktu Kehadiran' => $item->kehadiran,
                ];
            });
        } catch (\Throwable $th) {
            // Log error
            Log::error('Kesalahan saat mengekspor data absensi: ' . $th->getMessage());

            return response()->json(['error' => 'Terjadi kesalahan saat mengekspor data absensi.'], 500);
        }
    }

    public function destroy($id)
    {
        $absen = Absensi::findOrFail($id);
        $absen->delete();

        return redirect()->back()->with('success', 'Absensi berhasil dihapus.');
    }

}
