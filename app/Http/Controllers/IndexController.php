<?php

namespace App\Http\Controllers;

use App\Models\Crew;
use App\Models\Lokasi;
use App\Models\Proyek;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;


class IndexController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function show()
    {
        $jmlhCrew = Crew::all()->where('status_crew', true)->count();
        $jmlhLokasi = Lokasi::all()->count();
        $jmlhProyek = Proyek::all()->count();
        $projects = Proyek::all();
        $lokasis = Lokasi::all();
        return view('pages.index', compact('jmlhCrew','jmlhLokasi', 'jmlhProyek', 'projects', 'lokasis'));
    }

    public function tambahLokasi(Request $request)
{
    try {
        $request->validate([
            'nama_lokasi' => 'required|unique:lokasi',
        ]);

        Lokasi::create([
            'nama_lokasi' => $request->input('nama_lokasi'),
        ]);

        return redirect()->back()->with('success', 'Data berhasil ditambahkan');
    } catch (ValidationException $e) {
        // Jika validasi gagal, kirim respon JSON ke client
        return response()->json(['errors' => $e->validator->errors()->all()], 422);
    } catch (\Exception $e) {
        return redirect()->back()->with('error', $e->getMessage())->withInput();
    }
}

    public function tambahProject(Request $request)
{
    try {
        $request->validate([
            'nama_proyek' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'lokasi_proyek_id' => 'required|exists:lokasi,id',
        ]);

        Proyek::create([
            'nama_proyek' => $request->input('nama_proyek'),
            'lokasi_proyek_id' => $request->input('lokasi_proyek_id'),
        ]);

        return redirect()->back()->with('success', 'Data berhasil ditambahkan');
    } catch (ValidationException $e) {
        // Jika validasi gagal, kirim respon JSON ke client
        return response()->json(['errors' => $e->validator->errors()->all()], 422);
    } catch (\Exception $e) {
        return redirect()->back()->with('error', $e->getMessage())->withInput();
    }
}


}
