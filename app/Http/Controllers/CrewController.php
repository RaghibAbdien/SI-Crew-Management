<?php

namespace App\Http\Controllers;

use DateTime;
use App\Models\Bank;
use App\Models\Crew;
use App\Models\Lokasi;
use App\Models\Proyek;
use App\Models\Dokumen;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class CrewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function show()
    {
        $lokasis = Lokasi::all();
        $projects = Proyek::all();
        $banks = Bank::all();
        $crews = Crew::all();
        $docs = Dokumen::join('crews', 'dokumens.id_crew', '=', 'crews.id_crew')
        ->select('dokumens.*', 'crews.id_crew', 'crews.no_rekening', 'crews.id_bank')
        ->get();
        foreach ($docs as $doc) {
            $awalMCU = new DateTime($doc->tgl_mcu);
            $berakhirMCU = new DateTime($doc->expired_mcu);
            $selisih = $awalMCU->diff($berakhirMCU)->format('%a hari');
            $doc->selisih_hari = $selisih;
        }
        foreach ($docs as $doc) {
            $awalKontrak = new DateTime($doc->awal_kontrak);
            $berakhirKontrak = new DateTime($doc->berakhir_kontrak);
            $interval = $awalKontrak->diff($berakhirKontrak);
            $sisaKontrak = sprintf(
                '%d tahun %d bulan %d hari',
                $interval->y,
                $interval->m,
                $interval->d
            );
            $doc->kontrak = $sisaKontrak;
        }
        $notifs = Notification::join('crews', 'notifications.id_crew', '=', 'crews.id_crew')
        ->where('is_notif', true)
        ->select('notifications.*', 'crews.nama_crew')
        ->get();
        $NotifNotReadNum = Notification::where('is_read', false)->count();
        $updates = Crew::join('dokumens', 'crews.id_crew', '=', 'dokumens.id_crew')
        ->select('crews.*', 'dokumens.*')
        ->get();
        $isEdit = true;

        return view('pages.crew', compact('crews', 'docs', 'notifs', 'NotifNotReadNum', 'lokasis', 'banks', 'updates', 'isEdit', 'projects') );
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{

    DB::beginTransaction();

    try {
        $request->validate([
            'id_crew' => 'required|string|max:16|unique:crews|regex:/^\d+$/',
            'nama_crew' => 'required|string|max:50|regex:/^[a-zA-Z\s]+$/',
            'alamat_crew' => 'required|string',
            'email_crew' => 'required|email|max:50|unique:crews',
            'nohp_crew' => 'required|string|unique:crews|regex:/^\d+$/',
            'lokasi_crew_id' => 'required|exists:lokasi,id',
            'project_crew_id' => 'required|exists:proyeks,id',
            'id_bank' => 'required|exists:bank,id',
            'cv_path' => 'required|mimes:pdf|max:2048',
            'ktp_path' => 'required|mimes:pdf|max:2048',
            'vaksin_path.*' => 'required|mimes:pdf',
            'pkwt_path' => 'required|mimes:pdf|max:2048',
            'sertifikat_path.*' => 'required|mimes:pdf',
            'ijazah_path' => 'required|mimes:pdf|max:2048',
            'fotocrew_path' => 'required|mimes:jpeg,jpg,png',
            'npwp_path' => 'required|mimes:pdf|max:2048',
            'skck_path' => 'required|mimes:pdf|max:2048',
            'no_rekening' => 'required|min:5|unique:crews|regex:/^\d+$/',
            'mcu_path.*' => 'required|mimes:pdf|',
            'tgl_mcu' => 'required|date',
            'expired_mcu' => 'required|date|after_or_equal:tgl_mcu',
            'awal_kontrak' => 'required|date',
            'berakhir_kontrak' => 'required|date|after_or_equal:awal_kontrak',
        ],
        [
            'expired_mcu.after_or_equal' => 'The expired_mcu date must be a date after or equal to tgl_mcu.',
            'berakhir_kontrak.after_or_equal' => 'The berakhir_kontrak date must be a date after or equal to awal_kontrak.',
        ]
        );

        // Ambil input dari request
        $nama = $request->input('nama_crew');
        $warn_mcu = Carbon::parse($request->input('expired_mcu'))->subMonths(1);
        $warn_kontrak = Carbon::parse($request->input('berakhir_kontrak'))->subMonths(1);

        // Dapatkan file  dari request
        $cvFile = $request->file('cv_path');
        $ktpFile = $request->file('ktp_path');
        $vaksinFiles = $request->file('vaksin_path.*');
        $pkwtFile = $request->file('pkwt_path');
        $sertifikatFiles = $request->file('sertifikat_path.*');
        $ijazahFile = $request->file('ijazah_path');
        $fotoFile = $request->file('fotocrew_path');
        $npwpFile = $request->file('npwp_path');
        $skckFile = $request->file('skck_path');
        $mcuFiles = $request->file('mcu_path.*');

        // Tentukan nama file baru dengan nama input dan ekstensi asli
        $cvFileName = $nama . '_cv.' . $cvFile->getClientOriginalExtension();
        $ktpFileName = $nama . '_ktp.' . $ktpFile->getClientOriginalExtension();
        $pkwtFileName = $nama . '_pkwt.' . $pkwtFile->getClientOriginalExtension();
        $ijazahFileName = $nama . '_ijazah.' . $ijazahFile->getClientOriginalExtension();
        $fotoFileName = $nama . '_foto.' . $fotoFile->getClientOriginalExtension();
        $npwpFileName = $nama . '_npwp.' . $npwpFile->getClientOriginalExtension();
        $skckFileName = $nama . '_skck.' . $skckFile->getClientOriginalExtension();
 
        // Simpan file ke penyimpanan
        $cvPath = $cvFile->storeAs('public/uploads/cv', $cvFileName);
        $ktpPath = $ktpFile->storeAs('public/uploads/ktp', $ktpFileName);
        $pkwtPath = $pkwtFile->storeAs('public/uploads/pkwt', $pkwtFileName);
        $ijazahPath = $ijazahFile->storeAs('public/uploads/ijazah', $ijazahFileName);
        $fotoPath = $fotoFile->storeAs('public/uploads/foto', $fotoFileName);
        $npwpPath = $npwpFile->storeAs('public/uploads/npwp', $npwpFileName);
        $skckPath = $skckFile->storeAs('public/uploads/skck', $skckFileName);
 

        // Simpan multiple file vaksin dan sertifikat sebagai array JSON
        $vaksinPaths = [];
        if(!empty($vaksinFiles)) {
            if(is_array($vaksinFiles)) {
                // Jika lebih dari 1 file unggahan
                foreach ($vaksinFiles as $index => $vaksinFile) {
                    $vaksinFileName = $nama . '_vaksin_' . $index+1 . '.' . $vaksinFile->getClientOriginalExtension();
                    $vaksinPaths[] = $vaksinFile->storeAs('public/uploads/vaksin', $vaksinFileName);
                }
            } else {
                // Jika hanya 1 file unggahan
                $vaksinFileName = $nama . '_vaksin' .$vaksinFiles->getClientOriginalExtension();
                $vaksinPaths[] = $vaksinFiles->storeAs('public/uploads/vaksin', $vaksinFileName);
            }
        }


        $sertifikatPaths = [];
        if (!empty($sertifikatFiles)) {
            if (is_array($sertifikatFiles)) {
                // Jika lebih dari satu file diunggah
                foreach ($sertifikatFiles as $index => $sertifikatFile) {
                    $sertifikatFileName = $nama . '_sertifikat_' . $index+1 . '.' . $sertifikatFile->getClientOriginalExtension();
                    $sertifikatPaths[] = $sertifikatFile->storeAs('public/uploads/sertifikat', $sertifikatFileName);
                }
            } else {
                // Jika hanya satu file diunggah
                $sertifikatFileName = $nama . '_sertifikat.' . $sertifikatFiles->getClientOriginalExtension();
                $sertifikatPaths[] = $sertifikatFiles->storeAs('public/uploads/sertifikat', $sertifikatFileName);
            }
        }

        $mcuPaths = [];
        if (!empty($mcuFiles)) {
            if (is_array($mcuFiles)) {
                // Jika lebih dari satu file diunggah
                foreach ($mcuFiles as $index => $mcuFile) {
                    $mcuFileName = $nama . '_mcu_' . $index+1 . '.' . $mcuFile->getClientOriginalExtension();
                    $mcuPaths[] = $mcuFile->storeAs('public/uploads/mcu', $mcuFileName);
                }
            } else {
                // Jika hanya satu file diunggah
                $mcuFileName = $nama . '_mcu.' . $mcuFiles->getClientOriginalExtension();
                $mcuPaths[] = $mcuFiles->storeAs('public/uploads/mcu', $mcuFileName);
            }
        }


        // Buat record baru di tabel crews
        Crew::create([
            'id_crew' => $request->input('id_crew'),
            'nama_crew' => $request->input('nama_crew'),
            'alamat_crew' => $request->input('alamat_crew'),
            'email_crew' => $request->input('email_crew'),
            'nohp_crew' => $request->input('nohp_crew'),
            'lokasi_crew_id' => $request->input('lokasi_crew_id'),
            'proyek_crew_id' => $request->input('project_crew_id'),
            'id_bank' => $request->input('id_bank'),
            'no_rekening' => $request->input('no_rekening'),
        ]);

        Dokumen::create([
            'id_crew' => $request->input('id_crew'),
            'cv_path' => $cvPath, 
            'ktp_path' => $ktpPath,
            'vaksin_path' => json_encode($vaksinPaths),
            'pkwt_path' => $pkwtPath,
            'sertifikat_path' => json_encode($sertifikatPaths),
            'ijazah_path' => $ijazahPath,
            'fotocrew_path' => $fotoPath,
            'npwp_path' => $npwpPath,
            'skck_path' => $skckPath,
            'mcu_path' => json_encode($mcuPaths),
            'tgl_mcu' => $request->input('tgl_mcu'),
            'expired_mcu' => $request->input('expired_mcu'),
            'warn_mcu' => $warn_mcu,
            'awal_kontrak' => $request->input('awal_kontrak'),
            'berakhir_kontrak' => $request->input('berakhir_kontrak'),
            'warn_kontrak' => $warn_kontrak,
        ]);

        DB::commit();

        return redirect()->route('crew')->with('success', 'Data berhasil ditambahkan');
    } catch (ValidationException $e) {
        DB::rollBack();
        // Jika terjadi kesalahan validasi, kembali ke halaman sebelumnya dengan pesan kesalahan
        return response()->json(['errors' => $e->validator->errors()->all()], 422);
    } catch (\Exception $e) {
        // Jika terjadi kesalahan lain, kembali ke halaman sebelumnya dengan pesan kesalahan umum
        DB::rollBack();
        return redirect()->back()->with('error', $e->getMessage())->withInput();
    }
}


    /**
     * Show the form for editing the specified resource.
     */
    public function UpdateNotif(Request $request)
    {
        $notifId = $request->input('id');
        $isNotifTime = $request->input('duration');

        $notification = Notification::find($notifId);
        if ($notification) {
            // Update is_notif only if it is currently null
            if (is_null($notification->duration)) {
                $notification->duration = $isNotifTime;
            }
            $notification->is_read = true; // Misalnya, juga menandai sebagai sudah dibaca
            $notification->save();

            return response()->json(['message' => 'Notification status updated successfully.']);
        }

        return response()->json(['message' => 'Notification not found.'], 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateCrew(Request $request, string $id)
    {

        DB::beginTransaction();

        try {
 
            $crew = Crew::where('id_crew', $id)->first();
            $dokumen = $crew->documents;

            $request->validate([
                'nama_crew' => 'required|string|max:50|regex:/^[a-zA-Z\s]+$/',
                'alamat_crew' => 'required|string',
                'email_crew' => [
                    'required',
                    'email',
                    'max:50',
                    Rule::unique('crews', 'email_crew')->ignore($crew, 'id_crew'),
                ],                
                'nohp_crew' => [
                    'required',
                    'string',
                    Rule::unique('crews', 'nohp_crew')->ignore($crew, 'id_crew'),
                    'regex:/^\d+$/'
                ],
                'lokasi_crew_id' => 'required|exists:lokasi,id',
                'project_crew_id' => 'required|exists:proyeks,id',
                'status_crew' => 'required|',
                'id_bank' => 'required|exists:bank,id',
                'no_rekening' => [
                    'required',
                    'min:5',
                    Rule::unique('crews', 'no_rekening')->ignore($crew, 'id_crew'),
                    'regex:/^\d+$/'
                ],
                'cv_path' => 'sometimes|mimes:pdf|max:2048',
                'ktp_path' => 'sometimes|mimes:pdf|max:2048',
                'vaksin_path.*' => 'sometimes|mimes:pdf',
                'pkwt_path' => 'sometimes|mimes:pdf|max:2048',
                'sertifikat_path.*' => 'sometimes|mimes:pdf',
                'ijazah_path' => 'sometimes|mimes:pdf|max:2048',
                'fotocrew_path' => 'sometimes|mimes:jpeg,jpg,png',
                'npwp_path' => 'sometimes|mimes:pdf|max:2048',
                'skck_path' => 'sometimes|mimes:pdf|max:2048',
                'mcu_path.*' => 'sometimes|mimes:pdf|',
                'tgl_mcu' => 'required|date',
                'expired_mcu' => 'required|date|after_or_equal:tgl_mcu',
                'awal_kontrak' => 'required|date',
                'berakhir_kontrak' => 'required|date|after_or_equal:awal_kontrak',
            ], [
                'expired_mcu.after_or_equal' => 'The expired_mcu date must be a date after or equal to tgl_mcu.',
                'berakhir_kontrak.after_or_equal' => 'The berakhir_kontrak date must be a date after or equal to awal_kontrak.',
            ]);

            

            // Ambil input dari request
            $nama = $request->input('nama_crew');
            $tglEXPMCU = $request->input('expired_mcu');
            if($tglEXPMCU != $dokumen->expired_mcu){
                $warn_mcu = Carbon::parse($tglEXPMCU)->subMonths(1);
                $dokumen->update(['is_notif_mcu' => false, 'expired_mcu' => $tglEXPMCU]);
                Log::info('Tanggal Peringatan MCU: ' . $warn_mcu);
            } else{
                $warn_mcu = $dokumen->warn_mcu;
            }
            
            $tglBerakhirKontrak = $request->input('berakhir_kontrak');
            if($tglBerakhirKontrak != $dokumen->berakhir_kontrak){
                $warn_kontrak = Carbon::parse($tglBerakhirKontrak)->subMonths(1);
                $dokumen->update(['is_notif_kontrak' => false, 'berakhir_kontrak' => $tglBerakhirKontrak]);
                Log::info('Tanggal Peringatan Kontrak: ' . $warn_kontrak);
            } else{
                $warn_kontrak = $dokumen->warn_kontrak;
            }

            // Dapatkan file dari request jika ada
            $cvFile = $request->file('cv_path');
            $ktpFile = $request->file('ktp_path');
            $vaksinFiles = $request->file('vaksin_path.*');
            $pkwtFile = $request->file('pkwt_path');
            $sertifikatFiles = $request->file('sertifikat_path.*');
            $ijazahFile = $request->file('ijazah_path');
            $fotoFile = $request->file('fotocrew_path');
            $npwpFile = $request->file('npwp_path');
            $skckFile = $request->file('skck_path');
            $mcuFiles = $request->file('mcu_path.*');

            // Simpan file baru dan hapus file lama jika ada
            if ($cvFile) {
                Storage::delete($dokumen->cv_path);
                $cvFileName = $nama . '_cv.' . $cvFile->getClientOriginalExtension();
                $cvPath = $cvFile->storeAs('public/uploads/cv', $cvFileName);
            } else {
                $cvPath = $dokumen->cv_path;
            }

            if ($ktpFile) {
                Storage::delete($dokumen->ktp_path);
                $ktpFileName = $nama . '_ktp.' . $ktpFile->getClientOriginalExtension();
                $ktpPath = $ktpFile->storeAs('public/uploads/ktp', $ktpFileName);
            } else {
                $ktpPath = $dokumen->ktp_path;
            }

            // Simpan multiple file vaksin sebagai array JSON
            $vaksinPaths = json_decode($dokumen->vaksin_path, true);
            if (!empty($vaksinFiles)) {
                if (is_array($vaksinFiles)) {
                    foreach ($vaksinFiles as $index => $vaksinFile) {
                        $vaksinFileName = $nama . '_vaksin_' . (count($vaksinPaths) + $index + 1) . '.' . $vaksinFile->getClientOriginalExtension();
                        $vaksinPaths[] = $vaksinFile->storeAs('public/uploads/vaksin', $vaksinFileName);
                    }
                } else {
                    $vaksinFileName = $nama . '_vaksin.' . $vaksinFiles->getClientOriginalExtension();
                    $vaksinPaths[] = $vaksinFiles->storeAs('public/uploads/vaksin', $vaksinFileName);
                }
            }

            // Simpan multiple file sertifikat sebagai array JSON, tanpa menghapus file lama
            $sertifikatPaths = json_decode($dokumen->sertifikat_path, true);
            if (!empty($sertifikatFiles)) {
                if (is_array($sertifikatFiles)) {
                    foreach ($sertifikatFiles as $index => $sertifikatFile) {
                        $sertifikatFileName = $nama . '_sertifikat_' . (count($sertifikatPaths) + $index + 1) . '.' . $sertifikatFile->getClientOriginalExtension();
                        $sertifikatPaths[] = $sertifikatFile->storeAs('public/uploads/sertifikat', $sertifikatFileName);
                    }
                } else {
                    $sertifikatFileName = $nama . '_sertifikat_' . (count($sertifikatPaths) + 1) . '.' . $sertifikatFiles->getClientOriginalExtension();
                    $sertifikatPaths[] = $sertifikatFiles->storeAs('public/uploads/sertifikat', $sertifikatFileName);
                }
            }

            if ($pkwtFile) {
                Storage::delete($dokumen->pkwt_path);
                $pkwtFileName = $nama . '_pkwt.' . $pkwtFile->getClientOriginalExtension();
                $pkwtPath = $pkwtFile->storeAs('public/uploads/pkwt', $pkwtFileName);
            } else {
                $pkwtPath = $dokumen->pkwt_path;
            }

            if ($ijazahFile) {
                Storage::delete($dokumen->ijazah_path);
                $ijazahFileName = $nama . '_ijazah.' . $ijazahFile->getClientOriginalExtension();
                $ijazahPath = $ijazahFile->storeAs('public/uploads/ijazah', $ijazahFileName);
            } else {
                $ijazahPath = $dokumen->ijazah_path;
            }

            if ($fotoFile) {
                Storage::delete($dokumen->fotocrew_path);
                $fotoFileName = $nama . '_foto.' . $fotoFile->getClientOriginalExtension();
                $fotoPath = $fotoFile->storeAs('public/uploads/foto', $fotoFileName);
            } else {
                $fotoPath = $dokumen->fotocrew_path;
            }

            if ($npwpFile) {
                Storage::delete($dokumen->npwp_path);
                $npwpFileName = $nama . '_npwp.' . $npwpFile->getClientOriginalExtension();
                $npwpPath = $npwpFile->storeAs('public/uploads/npwp', $npwpFileName);
            } else {
                $npwpPath = $dokumen->npwp_path;
            }

            if ($skckFile) {
                Storage::delete($dokumen->skck_path);
                $skckFileName = $nama . '_skck.' . $skckFile->getClientOriginalExtension();
                $skckPath = $skckFile->storeAs('public/uploads/skck', $skckFileName);
            } else {
                $skckPath = $dokumen->skck_path;
            }

            $mcuPaths = json_decode($dokumen->mcu_path, true);
            if (!empty($mcuFiles)) {
                if (is_array($mcuFiles)) {
                    foreach ($mcuFiles as $index => $mcuFile) {
                        $mcuFileName = $nama . '_mcu_' . (count($mcuPaths) + $index + 1) . '.' . $mcuFile->getClientOriginalExtension();
                        $mcuPaths[] = $mcuFile->storeAs('public/uploads/mcu', $mcuFileName);
                    }
                } else {
                    $mcuFileName = $nama . '_mcu_' . (count($mcuPaths) + 1) . '.' . $mcuFiles->getClientOriginalExtension();
                    $mcuPaths[] = $mcuFiles->storeAs('public/uploads/mcu', $mcuFileName);
                }
            }    

            // Perbarui data crew
            $crew->update([
                'nama_crew' => $request->input('nama_crew'),
                'alamat_crew' => $request->input('alamat_crew'),
                'email_crew' => $request->input('email_crew'),
                'nohp_crew' => $request->input('nohp_crew'),
                'lokasi_crew_id' => $request->input('lokasi_crew_id'),
                'proyek_crew_id' => $request->input('project_crew_id'),
                'status_crew' => $request->input('status_crew'),
                'id_bank' => $request->input('id_bank'),
                'no_rekening' => $request->input('no_rekening'),
            ]);

            // Perbarui data dokumen
            $updateData = [
                'cv_path' => $cvPath,
                'ktp_path' => $ktpPath,
                'vaksin_path' => json_encode($vaksinPaths),
                'pkwt_path' => $pkwtPath,
                'sertifikat_path' => json_encode($sertifikatPaths),
                'ijazah_path' => $ijazahPath,
                'fotocrew_path' => $fotoPath,
                'npwp_path' => $npwpPath,
                'skck_path' => $skckPath,
                'mcu_path' => json_encode($mcuPaths),
                'tgl_mcu' => $request->input('tgl_mcu'),
                'warn_mcu' => $warn_mcu,
                'awal_kontrak' => $request->input('awal_kontrak'),
                'warn_kontrak' => $warn_kontrak,
            ];
            
            // Hapus kunci dengan nilai null dari array updateData
            $updateData = array_filter($updateData, function($value) {
                return !is_null($value);
            });
            
            // Lakukan update jika array updateData tidak kosong
            if (!empty($updateData)) {
                $dokumen->update($updateData);
            }
            

            DB::commit();

            return redirect()->route('crew')->with('success', 'Data berhasil diperbarui');
        } catch (ValidationException $e) {
            DB::rollBack();
            // Jika terjadi kesalahan validasi, kembali ke halaman sebelumnya dengan pesan kesalahan
            return response()->json(['errors' => $e->validator->errors()->all()], 422);
        } catch (\Exception $e) {
            // Jika terjadi kesalahan lain, kembali ke halaman sebelumnya dengan pesan kesalahan umum
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }


    }

    /**
     * Remove the specified resource from storage.
     */
        public function hapusSertif(Request $request, $id)
    {
        $indexToRemove = $request->input('index');

        Log::info('Index to remove: ' . $indexToRemove);

        // Ambil data user berdasarkan ID
        $doc = Dokumen::find($id);

        if ($doc) {
            // Decode kolom sertifikat_path ke array
            $sertifikatPathArray = json_decode($doc->sertifikat_path, true);

            Log::info('Current certificate paths: ' . json_encode($sertifikatPathArray));

            // Periksa apakah indeks yang ingin dihapus ada dalam array
            if (isset($sertifikatPathArray[$indexToRemove])) {
                // Hapus objek dari array
                unset($sertifikatPathArray[$indexToRemove]);

                // Reindex array untuk menghilangkan gap dalam array numerik
                $sertifikatPathArray = array_values($sertifikatPathArray);

                // Encode array kembali ke JSON
                $updatedSertifikatPath = json_encode($sertifikatPathArray);

                // Simpan perubahan ke database
                $doc->sertifikat_path = $updatedSertifikatPath;
                $doc->save();

                return redirect()->back()->with('success', 'Sertifikat berhasil dihapus');
            } else {
                Log::error('Index not found in certificate paths');
                return redirect()->back()->with('error', 'Indeks tidak ditemukan');
            }
        } else {
            Log::error('Document not found');
            return redirect()->back()->with('error', 'Dokumen tidak ditemukan');
        }
    }

}
