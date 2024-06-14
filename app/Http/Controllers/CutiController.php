<?php

namespace App\Http\Controllers;

use App\Models\Crew;
use App\Models\Cuti;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Rap2hpoutre\FastExcel\FastExcel;
use Illuminate\Validation\ValidationException;

class CutiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $crews = Crew::where('status_crew', true)->get();
        $cutis = Cuti::join('crews', 'cutis.id_crew', '=', 'crews.id_crew')
        ->select('cutis.*', 'crews.nama_crew')
        ->get();
        return view('pages.pengajuan-cuti', compact('crews', 'cutis'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'id_crew' => 'required|exists:crews,id_crew',
                'keperluan' => 'required|string',
                'tgl_mulai' => 'required|date',
                'tgl_berakhir' => 'required|date|after_or_equal:tgl_mulai',
                'surat_pengajuan' => 'required|mimes:pdf|max:2048'
            ]);

            // Ambil input dari request
            $nama = Crew::where('id_crew',$request->input('id_crew'))->value('nama_crew');

            // Dapatkan file  dari request
            $sp = $request->file('surat_pengajuan');

            // Tentukan nama file baru dengan nama input dan ekstensi asli
            $spNama = $nama . '_surat-pengajuan.' . $sp->getClientOriginalExtension();

            // Simpan file ke penyimpanan
            $spPath = $sp->storeAs('public/uploads/surat-pengajuan', $spNama);

            Cuti::create([
                'id_crew' => $request->input('id_crew'),
                'keperluan' => $request->input('keperluan'),
                'tgl_mulai' => $request->input('tgl_mulai'),
                'tgl_berakhir' => $request->input('tgl_berakhir'),
                'surat_pengajuan' => $spPath,
            ]);

            return redirect()->route('pengajuan-cuti')->with('success', 'Data berhasil ditambahkan');
        } catch (ValidationException $e) {
            // Jika terjadi kesalahan validasi, kembali ke halaman sebelumnya dengan pesan kesalahan
            return response()->json(['errors' => $e->validator->errors()->all()], 422);
        } catch (\Exception $e) {
            // Jika terjadi kesalahan lain, kembali ke halaman sebelumnya dengan pesan kesalahan umum
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function validasi($id, $action)
    {
        $cuti = Cuti::findOrFail($id);
        try {
            if($cuti){
                if($action == 'setuju'){
                    $cuti->status = 'Disetujui';
                } elseif($action == 'tolak'){
                    $cuti->status = 'Ditolak';
                } else {
                    return response()->json(['message' => 'Tindakan tidak valid.'], 400);
                }
                $cuti->save();
                return response()->json(['message' => 'Berhasil mengubah status cuti.']);
            } else {
            return response()->json(['message' => 'Data cuti tidak ditemukan.'], 404);
            }
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        $cuti = Cuti::findOrFail($id);
        $cuti->delete();

        return response()->json(['message' => 'Berhasil mengubah status cuti.']);
    }

    public function exportCuti()
    {
        // Ambil semua data absensi
        $dataCuti = DB::table('cutis')
        ->join('crews', 'cutis.id_crew', '=', 'crews.id_crew')
        ->select('crews.nama_crew', 'cutis.*')
        ->get();
        $no = 1;

        // Debug: Log jumlah data yang diambil
        Log::info('Jumlah data pengajuan cuti yang diambil: ' . $dataCuti->count());

        // Jika tidak ada data, log dan return error message
        if ($dataCuti->isEmpty()) {
            Log::warning('Tidak ada data pengajuan cuti yang tersedia untuk diekspor.');
            return response()->json(['error' => 'Tidak ada data pengajuan cuti yang tersedia untuk diekspor.'], 404);
        }

        try {
            return (new FastExcel($dataCuti))->download('data-pengajuan-cuti.xlsx', function ($item) use (&$no) {
                // Debug: Log setiap item yang diproses
                Log::info('Memproses item: ' . json_encode($item));

                // Periksa apakah $item->crews dan $item->kehadiran ada
                if (!$item->nama_crew) {
                    Log::error('Data item tidak lengkap: ' . json_encode($item));
                    throw new \Exception('Data item tidak lengkap.');
                }

                return [
                    'No.' => $no++,
                    'Nama Crew' => $item->nama_crew,
                    'Keperluan' => $item->keperluan,
                    'Tanggal Pengajuan' => $item->tgl_pengajuan,
                    'Tanggal Mulai' => $item->tgl_mulai,
                    'Tanggal Berakhir' => $item->tgl_berakhir,
                    'Status' => $item->status,
                ];
            });
        } catch (\Throwable $th) {
            // Log error
            Log::error('Kesalahan saat mengekspor data pengajuan cuti: ' . $th->getMessage());

            return response()->json(['error' => 'Terjadi kesalahan saat mengekspor data pengajuan cuti.'], 500);
        }
    }
}
